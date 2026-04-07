<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    // public function index()
    // {
    //     $selectedAgencyIds = session('agency_ids', []);

    //     $query = User::with('role')->latest();

    //     if (!empty($selectedAgencyIds)) {
    //         $query->whereIn('agency_id', $selectedAgencyIds);
    //     }

    //     $users = $query->get();

    //     $roles = Role::all();
    //     $agencies = Agency::all();

    //     return view('users.index', compact('users', 'roles', 'agencies'));
    // }
    public function index()
    {
        $authUser = Auth::user();
        $roleName = strtolower($authUser->role->name);

        $query = User::with('role')->latest();

        if (in_array($roleName, ['mis user', 'admin'])) {
            // Only users of the same agency
            $query->where('agency_id', $authUser->agency_id);

        } elseif (!empty(session('agency_ids', []))) {
            // Superadmin with session filter
            $query->whereIn('agency_id', session('agency_ids'));
        }
        // else superadmin with no filter → sees all

        $users    = $query->get();
        $roles    = Role::all();
        $agencies = Agency::all();

        return view('users.index', compact('users', 'roles', 'agencies', 'authUser'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'email'         => 'required|email|unique:users',
            'password'      => 'required',
            'role_id'       => 'required',
            'status'        => 'required',
            'date_of_birth' => 'required|date',
            'city'          => 'required',
            'state'         => 'required',
            'zip'           => 'required',
            'address'       => 'required',
            'agency_id'    => 'required|exists:agencies,id',
            'profile'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $profilePath = null;
        if ($request->hasFile('profile')) {
            $profilePath = $request->file('profile')->store('profiles', 'public');
        }

        User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role_id'       => $request->role_id,
            'status'        => $request->status,
            'city'          => $request->city,
            'state'         => $request->state,
            'zip'           => $request->zip,
            'address'       => $request->address,
            'agency_id' => $request->agency_id,
            'date_of_birth' => $request->date_of_birth,
            'profile'       => $profilePath
        ]);

        return response()->json(['success' => 'User has been created successfully.']);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'email'         => "required|email|unique:users,email,$id",
            'role_id'       => 'required',
            'status'        => 'required',
            'date_of_birth' => 'required|date',
            'city'          => 'required',
            'state'         => 'required',
            'zip'           => 'required',
            'address'       => 'required',
            'agency_id'     => 'nullable|exists:agencies,id',
            'profile'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::findOrFail($id);

        $data = $request->except('_token', 'password', 'profile');


        $data['agency_id'] = $request->agency_id;

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile')) {
            $data['profile'] = $request->file('profile')->store('profiles', 'public');
        }

        $user->update($data);

        return response()->json(['success' => 'User has been updated successfully.']);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['success' => 'User deleted successfully.']);
    }
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status;
        $user->save();

        return response()->json([
            'success' => true,
            'status' => $user->status,
            'message' => $user->status ? 'User activated.' : 'User deactivated.'
        ]);
    }
}
