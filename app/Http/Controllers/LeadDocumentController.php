<?php

namespace App\Http\Controllers;

use App\Models\LeadDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeadDocumentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'file|max:5120'
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {

                $filePath = $file->store('lead_documents', 'public');

                LeadDocument::create([
                    'lead_id' => $request->lead_id,
                    'uploaded_by' => auth()->id(),
                    'file' => $filePath,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        return back();
    }

        public function destroy($id)
        {
            $doc = LeadDocument::findOrFail($id);

            // Only allow super admin
            if (strtolower(auth()->user()->role->name) !== 'super admin') {
                abort(403, 'Only Super Admin can delete');
            }

            Storage::disk('public')->delete($doc->file);
            $doc->delete();

            return back();
        }
}
