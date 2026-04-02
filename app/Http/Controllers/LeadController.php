<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function index()
    {
        $authUser = Auth::user();

        $leads    = Lead::with(['agency', 'users'])->latest()->get();
        $agencies = Agency::all();

        if (strtolower($authUser->role->name) === 'user') {
            $users = User::where('agency_id', $authUser->agency_id)
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

        if (strtolower($authUser->role->name) === 'user') {
            $request->merge(['agency_id' => $authUser->agency_id]);
        }

        $validator = Validator::make($request->all(), [
            'name'               => 'required|string|max:255',
            'phone'              => 'required|string|max:20',
            'email'              => 'required|email|max:255',
            'company'            => 'required|string|max:255',
            'city'               => 'required|string|max:100',
            'source'             => 'required|string|max:100',
            'agency_id'          => 'required|exists:agencies,id',
            'assigned_user_id'   => 'required|array|min:1',
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
        ]);

        $lead->users()->sync($request->assigned_user_id);

        return response()->json(['success' => 'Lead created successfully']);
    }

    public function update(Request $request, $id)
    {
        $authUser = Auth::user();
        $lead     = Lead::findOrFail($id);

        if (strtolower($authUser->role->name) === 'user') {
            $request->merge(['agency_id' => $authUser->agency_id]);
        }

        $validator = Validator::make($request->all(), [
            'name'               => 'required|string|max:255',
            'phone'              => 'required|string|max:20',
            'email'              => 'required|email|max:255',
            'company'            => 'required|string|max:255',
            'city'               => 'required|string|max:100',
            'source'             => 'required|string|max:100',
            'status' => 'required|in:Not Started,In Progress,Hold,Lost,Complete',
            'agency_id'          => 'required|exists:agencies,id',
            'assigned_user_id'   => 'required|array|min:1',
            'assigned_user_id.*' => 'exists:users,id',
            'notes'              => 'required|string',
            'documents'          => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only([
            'name', 'phone', 'email', 'company',
            'city', 'source', 'status', 'agency_id', 'notes',
        ]);

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
        $header = ['name','phone','email','company','city','source','status','agency_id','notes'];

        // Example row (just a single row to show layout)
        $exampleRow = ['John Doe','1234567890','john@example.com','Example Inc','New York','Referral','Not Started','1','Test note'];

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
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Not Started,In Progress,Hold,Lost,Complete',
        ]);

        $lead = Lead::findOrFail($id);
        $lead->status = $request->status;
        $lead->save();

        return response()->json(['success' => 'Status updated successfully']);
    }
}
