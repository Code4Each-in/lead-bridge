<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $authUser = Auth::user();
        $roleName = strtolower($authUser->role->name);

        if ($roleName === 'super admin') {
            // Sees everything
            $totalAgencyUsers = User::count();
            $totalLeads       = Lead::count();
            $pendingLeads     = Lead::whereIn('status', ['Not Started', 'In Progress', 'Hold'])->count();
            $completedLeads   = Lead::where('status', 'Complete')->count();

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
            $myLeads          = Lead::whereHas('users', fn($q) => $q->where('users.id', $authUser->id));
            $totalLeads       = $myLeads->count();
            $pendingLeads     = (clone $myLeads)->whereIn('status', ['Not Started', 'In Progress', 'Hold'])->count();
            $completedLeads   = (clone $myLeads)->where('status', 'Complete')->count();
        }

        return view('dashboard.index', compact(
            'totalAgencyUsers',
            'totalLeads',
            'pendingLeads',
            'completedLeads'
        ));
    }
}
