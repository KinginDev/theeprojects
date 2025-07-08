<?php
namespace App\Providers;

use App\Classes\Helper;
use App\Helpers\MenuHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
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
            try {
                $merchant = Helper::merchant();
                $preferences = $merchant->preferences ?? [];
                $view->with('configuration', $preferences);
            } catch (\Exception $e) {
                // Fallback to default settings
                $settings = Helper::settings();
                $view->with('configuration', $settings);
            }
        });

        View::composer('admin-layout.*', function ($view) {
            $settings = Helper::settings();
            $view->with('configuration', $settings);
        });

        // Register a blade directive for menus
        Blade::directive('menu', function ($expression) {
            return "<?php echo App\Classes\Helper::renderMenu($expression); ?>";
        });
    }
}
