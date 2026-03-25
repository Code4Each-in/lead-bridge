<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::latest()->get();
        return view('roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Role::create([
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'Role created');
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required'
        ]);

        $role->update([
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'Role updated');
    }

    public function destroy($id)
    {
        Role::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Role deleted');
    }
}
