<?php
namespace App\Providers;

use App\Classes\Helper;
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
    public function boot(): void
    {
        // Share merchant preferences with all merchant views
        View::composer('merchant-layout.*', function ($view) {
            if (Auth::guard('merchant')->check()) {
                $merchantPreferences = Auth::guard('merchant')->user()->preferences;
                $view->with('configuration', $merchantPreferences);
            } else {
                // For non-authenticated pages like login, use global settings
                $settings = Helper::settings();
                $view->with('configuration', $settings);
            }
        });

        View::composer('users-layout.*', function ($view) {

            $merchant   = Helper::merchant();
            $prefrences = $merchant->preferences ?? [];
            $view->with('configuration', $prefrences);
        });

        View::composer('admin-layout.*', function ($view) {
            $settings = Helper::settings();
            $view->with('configuration', $settings);
        });
    }
}
