<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Shuchkin\SimpleXLSX;
use Shuchkin\SimpleXLS;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LeadImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $authUser = Auth::user();
        $userRole = strtolower($authUser->role->name ?? '');
        $authAgencyId = $authUser->agency_id;

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->getPathname();

        // Parse XLS/XLSX
        $extension = strtolower($file->getClientOriginalExtension());
        $rows = [];
        if ($extension === 'xlsx') {
            $xlsx = SimpleXLSX::parse($filePath);
            if (!$xlsx) return back()->with('error', 'Failed to parse XLSX file.');
            $rows = $xlsx->rows();
        } else {
            $xls = SimpleXLS::parse($filePath);
            if (!$xls) return back()->with('error', 'Failed to parse XLS file.');
            $rows = $xls->rows();
        }

        if (count($rows) < 2) {
            return back()->with('error', 'File is empty or missing data.');
        }

        $expectedHeader = ['name','phone','email','company','city','source','status','agency_id','notes'];
        $header = array_map('strtolower', $rows[0]);
        if ($header !== $expectedHeader) {
            return back()->with('error', 'Invalid template.');
        }

        // Fetch active Account Executives for distribution
        $accountExecs = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.status', 1)
            ->whereRaw('LOWER(roles.name) = ?', ['account executive'])
            ->where('users.agency_id', $authAgencyId)
            ->select('users.*')
            ->get();

        $pointer = 0; // Round-robin pointer
        $insertedCount = 0;
        $failedCount = 0;
        $failedRows = [];

        foreach ($rows as $index => $row) {
            if ($index === 0) continue;

            $name  = trim($row[0] ?? '');
            $phone = trim($row[1] ?? '');
            $email = trim($row[2] ?? '');
            $reason = null;

            if (empty($name) || (empty($email) && empty($phone))) {
                $reason = 'Missing mandatory fields (name, email/phone).';
            }

            if (!$reason) {
                $exists = DB::table('leads')
                    ->where(function($q) use ($email, $phone) {
                        if (!empty($email)) $q->orWhere('email', $email);
                        if (!empty($phone)) $q->orWhere('phone', $phone);
                    })
                    ->exists();

                if ($exists) {
                    $reason = 'Duplicate record (email or phone already exists).';
                }
            }

            if ($reason) {
                $failedCount++;
                $failedRows[] = [
                    'row' => $row,
                    'reason' => $reason,
                    'row_number' => $index + 1
                ];
                continue;
            }

            try {
                $leadId = DB::table('leads')->insertGetId([
                    'name'       => $name,
                    'phone'      => $phone,
                    'email'      => $email,
                    'company'    => $row[3] ?? null,
                    'city'       => $row[4] ?? null,
                    'source'     => $row[5] ?? null,
                    'status'     => $row[6] ?? 'New',
                    'agency_id'  => $authAgencyId,
                    'notes'      => $row[8] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Assign to Account Executive if available
                if ($accountExecs->isNotEmpty()) {
                    $assignedUser = $accountExecs[$pointer];
                    DB::table('lead_user')->insert([
                        'lead_id' => $leadId,
                        'user_id' => $assignedUser->id,
                    ]);
                    $pointer = ($pointer + 1) % $accountExecs->count();
                }

                $insertedCount++;

            } catch (\Exception $e) {
                $failedCount++;
                $failedRows[] = [
                    'row' => $row,
                    'reason' => 'Database error: ' . $e->getMessage(),
                    'row_number' => $index + 1
                ];
                \Log::error('Lead insert failed', ['row' => $row, 'error' => $e->getMessage()]);
            }
        }

        // Save failed CSV
        $failedFileName = null;
        if (!empty($failedRows)) {
            $failedFileName = 'failed_' . Str::random(6) . '_' . time() . '.csv';
            $handle = fopen(storage_path('app/' . $failedFileName), 'w');
            $csvHeader = array_merge($rows[0], ['reason', 'row_number']);
            fputcsv($handle, $csvHeader);
            foreach ($failedRows as $fail) {
                $rowData = $fail['row'];
                $rowData[] = $fail['reason'];
                $rowData[] = $fail['row_number'];
                fputcsv($handle, $rowData);
            }
            fclose($handle);
        }

        DB::table('lead_upload_logs')->insert([
            'file_name'      => $fileName,
            'inserted_count' => $insertedCount,
            'failed_count'   => $failedCount,
            'failed_file'    => $failedFileName,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return back()->with([
            'success' => "Upload completed. Inserted: $insertedCount, Failed: $failedCount",
            'failedRows' => $failedRows
        ]);
    }
}
