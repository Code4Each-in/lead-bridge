<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AgencyController extends Controller
{
    public function index()
    {
        $agencies = Agency::latest()->get();
        return view('agency.index', compact('agencies'));
    }


public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'agency_name'           => 'required',
        'primary_contact_name'  => 'required',
        'primary_email' => 'required|email|unique:agencies,primary_email',
        'password'              => 'required|min:6',
        'phone'                 => 'required',
        'address'               => 'required',
        'city'                  => 'required',
        'state'                 => 'required',
        'zip'                   => 'required',
        'logo'                  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    DB::beginTransaction();

    try {
        // Upload logo
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        // Create agency
        $agency = Agency::create([
            'agency_name'          => $request->agency_name,
            'primary_contact_name' => $request->primary_contact_name,
            'primary_email'        => $request->primary_email,
            'phone'                => $request->phone,
            'address'              => $request->address,
            'city'                 => $request->city,
            'state'                => $request->state,
            'zip'                  => $request->zip,
            'logo'                 => $logoPath,
        ]);

        // Create user
        User::create([
            'role_id'   => 2,
            'name'      => $request->primary_contact_name,
            'email'     => $request->primary_email,
            'password'  => Hash::make($request->password),
            'address'   => $request->address,
            'city'      => $request->city,
            'state'     => $request->state,
            'zip'       => $request->zip,
            'agency_id' => $agency->id,
            'profile'   => $logoPath,
        ]);

        DB::commit();

        return response()->json(['success' => 'Agency + User created successfully']);

    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function update(Request $request, $id)
{
    $agency = Agency::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'agency_name'           => 'required',
        'primary_contact_name'  => 'required',
        'primary_email'         => 'required|email',
        'phone'                 => 'required',
        'address'               => 'required',
        'city'                  => 'required',
        'state'                 => 'required',
        'zip'                   => 'required',
        'logo'                  => 'nullable|image',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    DB::beginTransaction();

    try {
        // Upload new logo
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $agency->logo = $logoPath;
        }

        $agency->update($request->except(['logo', 'password']));

        // Update user
        $user = User::where('agency_id', $agency->id)->first();

        if ($user) {
            $user->update([
                'name'    => $request->primary_contact_name,
                'email'   => $request->primary_email,
                'address' => $request->address,
                'city'    => $request->city,
                'state'   => $request->state,
                'zip'     => $request->zip,
            ]);

            if ($request->password) {
                $user->password = Hash::make($request->password);
                $user->save();
            }
        }

        DB::commit();

        return response()->json(['success' => 'Agency updated successfully']);

    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function destroy($id)
    {
        Agency::findOrFail($id)->delete();

        return response()->json(['success' => 'Agency deleted successfully']);
    }
}
