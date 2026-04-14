<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use App\Models\Agency;
use App\Models\LeadReminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class LeadController extends Controller
{
    // public function index()
    // {
    //     $authUser = Auth::user();

    //     $leads    = Lead::with(['agency', 'users'])->latest()->get();
    //     $agencies = Agency::all();

    //     $roleName = strtolower($authUser->role->name);

    //     if (in_array($roleName, ['mis user', 'admin'])) {
    //         $users = User::where('agency_id', $authUser->agency_id)
    //             ->whereHas('role', function ($q) {
    //                 $q->whereRaw('LOWER(name) = ?', ['account executive']);
    //             })
    //             ->where('id', '!=', $authUser->id)
    //             ->get();
    //     } else {
    //         $users = User::all();
    //     }

    //     return view('leads.index', compact('leads', 'users', 'agencies', 'authUser'));
    // }
    public function index()
    {
        $authUser = Auth::user();
        $roleName = strtolower($authUser->role->name);

        // Build leads query
        $leadsQuery = Lead::with(['agency', 'users'])->latest();

        if (in_array($roleName, ['mis user', 'admin'])) {
            // Only leads belonging to same agency
            $leadsQuery->where('agency_id', $authUser->agency_id);

        } elseif ($roleName === 'account executive') {
            // Only leads assigned to this user
            $leadsQuery->whereHas('users', function ($q) use ($authUser) {
                $q->where('users.id', $authUser->id);
            });
        }
        // superadmin → no filter, sees everything

        $leads    = $leadsQuery->get();
        $agencies = Agency::all();

        if (in_array($roleName, ['mis user', 'admin'])) {
            $users = User::where('agency_id', $authUser->agency_id)
                ->whereHas('role', function ($q) {
                    $q->whereRaw('LOWER(name) = ?', ['account executive']);
                })
                ->where('id', '!=', $authUser->id)
                ->get();
        } else {
            $users = User::all();
        }

        return view('leads.index', compact('leads', 'users', 'agencies', 'authUser'));
    }
    public function store(Request $request)
    {
        $authUser = Auth::user();

        $roleName = strtolower($authUser->role->name);

        // Force agency for restricted roles
        if (in_array($roleName, ['mis user', 'admin'])) {
            $request->merge([
                'agency_id' => $authUser->agency_id
            ]);
        }
        $validator = Validator::make($request->all(), [
            'name'               => 'required|string|max:255',
            'phone'              => 'required|string|max:20',
            'email'              => 'required|email|max:255',
            'company'            => 'required|string|max:255',
            'city'               => 'required|string|max:100',
            'source'             => 'required|string|max:100',
            'agency_id'          => 'nullable|exists:agencies,id',
            'assigned_user_id'   => 'nullable|min:1',
            'assigned_user_id.*' => 'exists:users,id',
            'notes'              => 'required|string',
            'documents'          => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $file = null;
        if ($request->hasFile('documents')) {
            $file = $request->file('documents')->store('leads', 'public');
        }

        $lead = Lead::create([

            'name'      => $request->name,
            'phone'     => $request->phone,
            'email'     => $request->email,
            'company'   => $request->company,
            'city'      => $request->city,
            'source'    => $request->source,
            'status'    => 'Not Started',
            'agency_id' => $request->agency_id,
            'notes'     => $request->notes,
            'documents' => $file,
            'created_by'  => $authUser->id,
        ]);

        $lead->users()->sync($request->assigned_user_id);

        return response()->json(['success' => 'Lead created successfully']);
    }

    // public function update(Request $request, $id)
    // {
    //     $authUser = Auth::user();
    //     $lead     = Lead::findOrFail($id);

    //     $roleName = strtolower($authUser->role->name);

    //     // Force agency for restricted roles
    //     if (in_array($roleName, ['mis user', 'admin'])) {
    //         $request->merge([
    //             'agency_id' => $authUser->agency_id
    //         ]);
    //     }
    //     $validator = Validator::make($request->all(), [
    //         'name'               => 'required|string|max:255',
    //         'phone'              => 'required|string|max:20',
    //         'email'              => 'required|email|max:255',
    //         'company'            => 'required|string|max:255',
    //         'city'               => 'required|string|max:100',
    //         'source'             => 'required|string|max:100',
    //         'status' => 'required|in:Not Started,In Progress,Hold,Lost,Complete',
    //         'agency_id'          => 'nullable|exists:agencies,id',
    //         'assigned_user_id'   => 'nullable|array|min:1',
    //         'assigned_user_id.*' => 'exists:users,id',
    //         'notes'              => 'required|string',
    //         'documents'          => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $data = $request->only([
    //         'name', 'phone', 'email', 'company',
    //         'city', 'source', 'status', 'agency_id', 'notes',
    //     ]);

    //     if ($request->hasFile('documents')) {
    //         $data['documents'] = $request->file('documents')->store('leads', 'public');
    //     }

    //     $lead->update($data);

    //     $lead->users()->sync($request->assigned_user_id);

    //     return response()->json(['success' => 'Lead updated successfully']);
    // }


    public function update(Request $request, $id)
    {
        $authUser = Auth::user();
        $lead     = Lead::findOrFail($id);

        $roleName = strtolower($authUser->role->name);

        if (in_array($roleName, ['mis user', 'admin'])) {
            $request->merge([
                'agency_id' => $authUser->agency_id
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:255',
            'phone'  => 'required|string|max:20',
            'email'  => 'required|email|max:255',
            'company'=> 'required|string|max:255',
            'city'   => 'required|string|max:100',
            'source' => 'required|string|max:100',
            'status' => 'required|in:Not Started,In Progress,Hold,Lost,Complete',
            'agency_id' => 'nullable|exists:agencies,id',
            'assigned_user_id'   => 'nullable|min:1',
            'assigned_user_id.*' => 'exists:users,id',
            'notes' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only([
            'name','phone','email','company',
            'city','source','status','agency_id','notes',
        ]);


        if ($request->status === 'In Progress' && !$lead->start_date) {
            $data['start_date'] = Carbon::now();
        }

        if ($request->status === 'Complete' && !$lead->end_date) {
            $data['end_date'] = Carbon::now();
        }

        // Optional: reset end_date if reopened
        if ($request->status !== 'Complete') {
            $data['end_date'] = null;
        }

        if ($request->hasFile('documents')) {
            $data['documents'] = $request->file('documents')->store('leads', 'public');
        }

        $lead->update($data);

        $lead->users()->sync($request->assigned_user_id);

        return response()->json(['success' => 'Lead updated successfully']);
    }
    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();

        return response()->json(['success' => 'Lead deleted successfully']);
    }
    public function downloadTemplate()
    {
        $filename = 'leads_template.csv';

        // Header row
        $header = ['name','phone','email','company','city','source','status','notes'];

        // Example row (just a single row to show layout)
        $exampleRow = ['John Doe','1234567890','john@example.com','Example Inc','New York','Referral','Not Started','Test note'];

        // Open output stream
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, $header);
        fputcsv($handle, $exampleRow);
        rewind($handle);

        $contents = stream_get_contents($handle);
        fclose($handle);

        return Response::make($contents, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }
    // public function updateStatus(Request $request, $id)
    // {
    //     $request->validate([
    //         'status' => 'required|in:Not Started,In Progress,Hold,Lost,Complete',
    //     ]);

    //     $lead = Lead::findOrFail($id);
    //     $lead->status = $request->status;
    //     $lead->save();

    //     return response()->json(['success' => 'Status updated successfully']);
    // }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Not Started,In Progress,Hold,Lost,Complete',
        ]);

        $lead = Lead::findOrFail($id);

        if ($request->status === 'In Progress' && !$lead->start_date) {
            $lead->start_date = now();
        }

        if ($request->status === 'Complete' && !$lead->end_date) {
            $lead->end_date = now();
        }

        if ($request->status !== 'Complete') {
            $lead->end_date = null;
        }

        $lead->status = $request->status;
        $lead->save();

        return response()->json(['success' => 'Status updated successfully']);
    }
    public function showLead($id)
    {
        $lead = Lead::with([
            'agency',
            'users',
            'leadNotes.user',
            'leadNotes.documents',
            'leadDocuments'
        ])->findOrFail($id);

        $activities = collect();


        foreach ($lead->leadNotes as $note) {
            $activities->push([
                'type' => 'note',
                'data' => $note,
                'created_at' => $note->created_at
            ]);
        }

        foreach ($lead->leadDocuments as $doc) {
            $activities->push([
                'type' => 'document',
                'data' => $doc,
                'created_at' => $doc->created_at
            ]);
        }


        $activities = $activities->sortBy('created_at')->values();
        $authUser = auth()->user();
        $roleName = $authUser->role->name ?? null;

        $query = LeadReminder::where('lead_id', $id);

        if ($roleName !== 'super admin') {
            $query->where('agency_id', $authUser->agency_id);
        }

        $reminders = LeadReminder::where('lead_id', $id)->latest()->get();
        return view('leads.show', compact('lead', 'activities','reminders'));
    }
    public function storeReminder(Request $request)
    {
        $authUser = auth()->user();
        $roleName = strtolower($authUser->role->name ?? '');


        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'date'    => 'required|date|after_or_equal:today',
            'time'    => 'required',
            'notes'   => 'nullable|string'
        ]);

        $agencyId = match ($roleName) {
            'admin', 'mis user' => $authUser->agency_id,
            'super admin'       => null,
            default             => $authUser->agency_id,
        };

        LeadReminder::create([
            'user_id'   => $authUser->id,
            'lead_id'   => $request->lead_id,
            'agency_id' => $agencyId,
            'date'      => $request->date,
            'time'      => $request->time,
            'notes'     => $request->notes,
            'is_triggered' => 0
        ]);

        return back()->with('success', 'Reminder added successfully');
    }
    public function destroyReminder($id)
    {
        $reminder = LeadReminder::findOrFail($id);

        if ($reminder->user_id != auth()->id()) {
            return back()->with('error', 'You cannot delete this reminder. Only creator can delete it.');
        }

        $reminder->delete();

        return back()->with('success', 'Reminder deleted successfully');
    }

}
