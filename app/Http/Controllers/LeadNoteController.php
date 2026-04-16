<?php

namespace App\Http\Controllers;

use App\Models\LeadNote;
use Illuminate\Http\Request;
use App\Models\LeadDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LeadActivityNotification;
use App\Models\Lead;

class LeadNoteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string',
            'files.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120'
        ]);

        $note = null;

        // Save note
        if ($request->content) {
            $note = LeadNote::create([
                'lead_id' => $request->lead_id,
                'user_id' => auth()->id(),
                'content' => $request->content,
            ]);
        }

        // Save multiple files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {

                $destinationPath = public_path('assets/lead_documents');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $fileName = time() . '_' . $file->getClientOriginalName();

                $file->move($destinationPath, $fileName);

                $filePath = 'assets/lead_documents/' . $fileName;

                LeadDocument::create([
                    'lead_id' => $request->lead_id,
                    'note_id' => $note?->id,
                    'uploaded_by' => auth()->id(),
                    'file' => $filePath,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => file_exists(public_path($filePath))
                        ? filesize(public_path($filePath))
                        : 0,
                ]);
            }
        }
            $lead = Lead::find($request->lead_id);

            $users = $lead->involvedUsers();

            Notification::send(
                $lead->involvedUsers(),
                new LeadActivityNotification(
                    $lead,
                    'note_added',
                    'A new note has been added to the lead.'
                )
            );
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
        $doc = LeadDocument::findOrFail($id);

        if (strtolower(auth()->user()->role->name) !== 'super admin') {
            abort(403, 'Only Super Admin can delete');
        }

        if ($doc->file && file_exists(public_path($doc->file))) {
            unlink(public_path($doc->file));
        }

        $doc->delete();

        return back();
    }
}
