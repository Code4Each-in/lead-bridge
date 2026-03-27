<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            'agency_name'     => 'required',
            'primary_contact' => 'required',
            'phone'           => 'required',
            'address'         => 'required',
            'city'            => 'required',
            'state'           => 'required',
            'zip'             => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Agency::create($request->all());

        return response()->json(['success' => 'Agency created successfully']);
    }

    public function update(Request $request, $id)
    {
        $agency = Agency::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'agency_name'     => 'required',
            'primary_contact' => 'required',
            'phone'           => 'required',
            'address'         => 'required',
            'city'            => 'required',
            'state'           => 'required',
            'zip'             => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $agency->update($request->all());

        return response()->json(['success' => 'Agency updated successfully']);
    }

    public function destroy($id)
    {
        Agency::findOrFail($id)->delete();

        return response()->json(['success' => 'Agency deleted successfully']);
    }
}
