<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use App\Models\Agency;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $authUser = Auth::user();
        $roleName = strtolower($authUser->role->name);

        // Take first selected agency from session, fallback to user's agency
        $agencyId = session('agency_ids', [$authUser->agency_id])[0] ?? $authUser->agency_id;

        $agency = Agency::find($agencyId);
        $agencyName = optional($agency)->agency_name ?? 'Lead Bridge';


        if ($roleName === 'super admin') {
            if ($agencyId) {
                // Super admin filtered by selected agency
                $totalAgencyUsers = User::where('agency_id', $agencyId)->count();
                $totalLeads       = Lead::where('agency_id', $agencyId)->count();
                $pendingLeads     = Lead::where('agency_id', $agencyId)
                                        ->whereIn('status', ['Not Started', 'In Progress', 'Hold'])
                                        ->count();
                $completedLeads   = Lead::where('agency_id', $agencyId)
                                        ->where('status', 'Complete')
                                        ->count();
            } else {
                // Super admin sees all agencies
                $totalAgencyUsers = User::count();
                $totalLeads       = Lead::count();
                $pendingLeads     = Lead::whereIn('status', ['Not Started', 'In Progress', 'Hold'])->count();
                $completedLeads   = Lead::where('status', 'Complete')->count();
            }

        } elseif (in_array($roleName, ['mis user', 'admin'])) {
            $totalAgencyUsers = User::where('agency_id', $authUser->agency_id)->count();
            $totalLeads       = Lead::where('agency_id', $authUser->agency_id)->count();
            $pendingLeads     = Lead::where('agency_id', $authUser->agency_id)
                                    ->whereIn('status', ['Not Started', 'In Progress', 'Hold'])
                                    ->count();
            $completedLeads   = Lead::where('agency_id', $authUser->agency_id)
                                    ->where('status', 'Complete')
                                    ->count();
        } else {
            // Account Executive — only their assigned leads
            $totalAgencyUsers = 1;
            $myLeads = Lead::whereHas('users', fn($q) => $q->where('users.id', $authUser->id));
            $totalLeads     = $myLeads->count();
            $pendingLeads   = (clone $myLeads)->whereIn('status', ['Not Started', 'In Progress', 'Hold'])->count();
            $completedLeads = (clone $myLeads)->where('status', 'Complete')->count();
        }

        $defaultCity = $authUser->city ?? 'Chandigarh';

        $response = Http::get('http://api.weatherapi.com/v1/current.json', [
            'key' => env('WEATHER_API_KEY'),
            'q'   => $defaultCity
        ]);

        $weatherData = $response->json();
        $temp    = data_get($weatherData, 'current.temp_c', '--');
        $city    = data_get($weatherData, 'location.name', $defaultCity);
        $country = data_get($weatherData, 'location.country', 'India');

        return view('dashboard.index', compact(
            'totalAgencyUsers',
            'totalLeads',
            'pendingLeads',
            'completedLeads',
            'temp',
            'city',
            'country',
            'agencyName'
        ));
    }
}
