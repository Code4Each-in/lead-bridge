<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->latest()->get();
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
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
        'profile'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = User::findOrFail($id);
    $data = $request->except('_token', 'password', 'profile');

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
}
