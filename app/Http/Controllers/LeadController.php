<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function index()
    {
        // Eager-load pivot users (many-to-many) + agency
        $leads    = Lead::with(['agency', 'users'])->latest()->get();
        $users    = User::all();
        $agencies = Agency::all();

        return view('leads.index', compact('leads', 'users', 'agencies'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'               => 'required|string|max:255',
            'phone'              => 'required|string|max:20',
            'email'              => 'required|email|max:255',
            'company'            => 'required|string|max:255',
            'city'               => 'required|string|max:100',
            'source'             => 'required|string|max:100',
            'status'             => 'required|in:New,In Progress,Closed',
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
            'status'    => $request->status ?? 'New',
            'agency_id' => $request->agency_id,
            'notes'     => $request->notes,
            'documents' => $file,
        ]);

        // Sync pivot — stores all selected user IDs into lead_user table
        $lead->users()->sync($request->assigned_user_id);

        return response()->json(['success' => 'Lead created successfully']);
    }

    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'               => 'required|string|max:255',
            'phone'              => 'required|string|max:20',
            'email'              => 'required|email|max:255',
            'company'            => 'required|string|max:255',
            'city'               => 'required|string|max:100',
            'source'             => 'required|string|max:100',
            'status'             => 'required|in:New,In Progress,Closed',
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

        // Sync pivot — replaces old user assignments with the new selection
        $lead->users()->sync($request->assigned_user_id);

        return response()->json(['success' => 'Lead updated successfully']);
    }

    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();

        return response()->json(['success' => 'Lead deleted successfully']);
    }
}
