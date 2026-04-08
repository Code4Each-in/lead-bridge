<?php

namespace App\Providers;

use App\Models\Agency;
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
        $agencies = Agency::all(); // all agencies

        $selectedIds = session('agency_ids', []); // IDs stored in session
        $currentAgency = !empty($selectedIds) ? Agency::find($selectedIds[0]) : null;

        $view->with([
            'agencies' => $agencies,
            'currentAgency' => $currentAgency
        ]);
    });
}
}
