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
        // 1️⃣ Validate uploaded file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->getPathname();

        // 2️⃣ Parse Excel file
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

        // 3️⃣ Verify template header
        $expectedHeader = ['name','phone','email','company','city','source','status','agency_id','notes'];
        $header = array_map('strtolower', $rows[0]);
        if ($header !== $expectedHeader) {
            return back()->with('error', 'Invalid template. Please use the predefined template.');
        }

        // 4️⃣ Counters & failed rows array
        $insertedCount = 0;
        $failedCount = 0;
        $failedRows = [];

        // 5️⃣ Process each row
        foreach ($rows as $index => $row) {
            if ($index === 0) continue; // skip header

            $name     = trim($row[0] ?? '');
            $phone    = trim($row[1] ?? '');
            $email    = trim($row[2] ?? '');
            $agencyId = trim($row[7] ?? '');

            $reason = null;

            // 5a️⃣ Mandatory fields
            if (empty($name) || empty($agencyId) || (empty($email) && empty($phone))) {
                $reason = 'Missing mandatory fields (name, agency_id, email/phone)';
            }

            // 5b️⃣ Duplicate check
            $exists = DB::table('leads')
                ->where(function($q) use ($email, $phone) {
                    if (!empty($email)) $q->orWhere('email', $email);
                    if (!empty($phone)) $q->orWhere('phone', $phone);
                })
                ->exists();

            if (!$reason && $exists) {
                $reason = 'Duplicate record (email or phone already exists)';
            }

            // 5c️⃣ If failed, store reason
            if ($reason) {
                $failedCount++;
                $failedRows[] = [
                    'row' => $row,
                    'reason' => $reason,
                    'row_number' => $index + 1
                ];
                continue;
            }

            // 5d️⃣ Insert into DB
            try {
                DB::table('leads')->insert([
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

        // 6️⃣ Save failed CSV if needed
        $failedFileName = null;
        if (!empty($failedRows)) {
            $failedFileName = 'failed_' . Str::random(6) . '_' . time() . '.csv';
            $handle = fopen(storage_path('app/' . $failedFileName), 'w');
            $csvHeader = array_merge($rows[0], ['reason', 'row_number']);
            fputcsv($handle, $csvHeader);

            foreach ($failedRows as $fail) {
                $rowData = $fail['row'];
                $rowData[] = $fail['reason'] ?? 'Unknown';
                $rowData[] = $fail['row_number'] ?? '';
                fputcsv($handle, $rowData);
            }

            fclose($handle);
        }

        // 7️⃣ Log upload
        DB::table('lead_upload_logs')->insert([
            'file_name'      => $fileName,
            'inserted_count' => $insertedCount,
            'failed_count'   => $failedCount,
            'failed_file'    => $failedFileName,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        // 8️⃣ Return response for SweetAlert
        return back()->with([
            'success' => "Upload completed. Inserted: $insertedCount, Failed: $failedCount",
            'failedRows' => $failedRows
        ]);
    }
    
}
