<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Show the profile page.
     */
    public function index()
    {
        return view('profile.index');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'date_of_birth' => 'required|date',
            'city'          => 'required',
            'state'         => 'required',
            'zip'           => 'required',
            'address'       => 'required',
            'profile'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile.index')
                ->withErrors($validator)
                ->withInput();
        }

        // Handle profile photo upload
        if ($request->hasFile('profile')) {
            // Delete old photo from storage if it exists
            if ($user->profile) {
                Storage::disk('public')->delete($user->profile);
            }
            $profilePath = $request->file('profile')->store('profiles', 'public');
            $user->profile = $profilePath;
        }

        $user->name          = $request->name;
        $user->email         = $request->email;
        $user->date_of_birth = $request->date_of_birth;
        $user->city          = $request->city;
        $user->state         = $request->state;
        $user->zip           = $request->zip;
        $user->address       = $request->address;
        $user->save();

        return redirect()->route('profile.index')
            ->with('success', 'Profile updated successfully.');
    }
}
