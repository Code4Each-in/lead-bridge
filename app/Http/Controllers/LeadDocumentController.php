<?php

namespace App\Http\Controllers;

use App\Models\LeadDocument;
use Illuminate\Http\Request;

class LeadDocumentController extends Controller
{
        public function store(Request $request)
        {
            $request->validate([
                'files.*' => 'file|max:5120' // each file max 5MB
            ]);

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {

                    $path = $file->store('lead_documents');

                    LeadDocument::create([
                        'lead_id' => $request->lead_id,
                        'uploaded_by' => auth()->id(),
                        'file' => $path,
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
        if (auth()->user()->role !== 'super_admin') {
            abort(403);
        }

        $doc = LeadDocument::findOrFail($id);

        Storage::delete($doc->file);
        $doc->delete();

        return back();
    }
}
