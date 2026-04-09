<?php

namespace App\Providers;

use App\Models\Agency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {

            $user = Auth::user();

            // Always prefer logged-in user's agency
            if ($user && $user->agency) {
                $currentAgency = $user->agency;
            } else {
                // fallback (for superadmin or no direct agency)
                $selectedIds = session('agency_ids', []);
                $currentAgency = !empty($selectedIds) ? Agency::find($selectedIds[0]) : null;
            }

            $agencies = Agency::all();

            $view->with([
                'agencies' => $agencies,
                'currentAgency' => $currentAgency
            ]);
        });
    }
}
