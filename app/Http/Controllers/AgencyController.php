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
        $selectedAgencyIds = session('agency_ids');

        if (!empty($selectedAgencyIds)) {
            $agencies = Agency::whereIn('id', $selectedAgencyIds)->latest()->get();
        } else {
            $agencies = Agency::latest()->get();
        }

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
            'logo'                  => 'nullable|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();

        try {
            // Upload logo
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $filename = time() . '_' . $request->file('logo')->getClientOriginalName();
                $request->file('logo')->move(public_path('assets/images'), $filename);

                $logoPath = 'assets/images/' . $filename;
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
            'logo'                  => 'nullable|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();

        try {
            // Upload new logo
            if ($request->hasFile('logo')) {

                // delete old file
                if ($agency->logo && file_exists(public_path($agency->logo))) {
                    unlink(public_path($agency->logo));
                }

                $filename = time() . '_' . $request->file('logo')->getClientOriginalName();
                $request->file('logo')->move(public_path('assets/images'), $filename);

                $agency->logo = 'assets/images/' . $filename;
            }

            $agency->update($request->except(['logo', 'password']));

            // Update user
            $user = User::where('agency_id', $agency->id)->first();
dd($user);
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
    public function setAgency(Request $request)
    {
        session(['agency_ids' => $request->agency_ids ?? []]);

        return response()->json(['success' => true]);
    }
}
