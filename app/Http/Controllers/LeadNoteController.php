<?php

namespace App\Http\Controllers;

use App\Models\LeadNote;
use Illuminate\Http\Request;
use App\Models\LeadDocument;
use Illuminate\Support\Facades\Storage;

class LeadNoteController extends Controller
{


    public function store(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string',
            'files.*' => 'file|max:5120'
        ]);

        // Save Note
        $note = LeadNote::create([
            'lead_id' => $request->lead_id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        // Save Files (if any)
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

    public function update(Request $request, $id)
    {
        $note = LeadNote::findOrFail($id);

        if ($note->user_id !== auth()->id()) {
            abort(403);
        }

        $note->update([
            'content' => $request->content,
            'is_edited' => true
        ]);

        return back();
    }

    public function destroy($id)
    {
        abort(403, 'Notes cannot be deleted');
    }
}
