<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Shuchkin\SimpleXLSX;
use Shuchkin\SimpleXLS;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->getPathname();

        // ✅ Parse Excel file
        $extension = strtolower($file->getClientOriginalExtension());
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

        // ✅ Validate header
        $expectedHeader = ['name','phone','email','company','city','source','status','agency_id','notes'];
        $header = array_map('strtolower', $rows[0]);
        if ($header !== $expectedHeader) {
            return back()->with('error', 'Invalid template. Please use the predefined template.');
        }

        // ✅ Get active Account Executives grouped by agency
        $agencyUsers = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.status', 1)
            ->where('roles.name', 'Account Executive')
            ->orderBy('users.id')
            ->select('users.*')
            ->get()
            ->groupBy('agency_id');

        // ✅ Track round-robin pointer per agency
        $agencyPointers = [];

        $insertedCount = 0;
        $failedCount = 0;
        $failedRows = [];

        foreach ($rows as $index => $row) {
            if ($index === 0) continue; // skip header

            $name     = trim($row[0] ?? '');
            $phone    = trim($row[1] ?? '');
            $email    = trim($row[2] ?? '');
            $agencyId = trim($row[7] ?? '');

            $reason = null;

            // ✅ Validation
            if (empty($name) || empty($agencyId) || (empty($email) && empty($phone))) {
                $reason = 'Missing mandatory fields (name, agency_id, email/phone)';
            }

            // ✅ Duplicate check
            $exists = DB::table('leads')
                ->where(function($q) use ($email, $phone) {
                    if (!empty($email)) $q->orWhere('email', $email);
                    if (!empty($phone)) $q->orWhere('phone', $phone);
                })
                ->exists();

            if (!$reason && $exists) {
                $reason = 'Duplicate record (email or phone already exists)';
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
                // ✅ Insert lead
                $leadId = DB::table('leads')->insertGetId([
                    'name'       => $name,
                    'phone'      => $phone,
                    'email'      => $email,
                    'company'    => $row[3] ?? null,
                    'city'       => $row[4] ?? null,
                    'source'     => $row[5] ?? null,
                    'status'     => $row[6] ?? 'New',
                    'agency_id'  => $agencyId,
                    'notes'      => $row[8] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // ✅ Lead Assignment (Round-Robin per Agency)
                if (isset($agencyUsers[$agencyId]) && count($agencyUsers[$agencyId]) > 0) {

                    if (!isset($agencyPointers[$agencyId])) {
                        $agencyPointers[$agencyId] = 0;
                    }

                    $users = $agencyUsers[$agencyId]->values(); // reset keys
                    $assignCount = 2; // number of AEs per lead

                    // handle if fewer users than assignCount
                    $assignCount = min($assignCount, count($users));

                    for ($i = 0; $i < $assignCount; $i++) {
                        $user = $users[$agencyPointers[$agencyId]];

                        DB::table('lead_user')->insert([
                            'lead_id' => $leadId,
                            'user_id' => $user->id,
                        ]);

                        // move pointer
                        $agencyPointers[$agencyId] =
                            ($agencyPointers[$agencyId] + 1) % count($users);
                    }
                }

                $insertedCount++;

            } catch (\Exception $e) {
                $failedCount++;
                $failedRows[] = [
                    'row' => $row,
                    'reason' => 'Database error: ' . $e->getMessage(),
                    'row_number' => $index + 1
                ];

                \Log::error('Lead insert failed', [
                    'row' => $row,
                    'error' => $e->getMessage()
                ]);
            }
        }

        // ✅ Generate failed CSV
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

        // ✅ Log upload
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
