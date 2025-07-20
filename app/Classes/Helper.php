<?php
namespace App\Classes;

use App\Models\Setting;
use App\Models\Merchant;
use Illuminate\Support\Str;
use App\Models\MerchantMenu;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Helper
{
    public static function merchant()
    {
        // First check if we already have the merchant in the app container
        if (app()->has('currentMerchant')) {
            return app('currentMerchant');
        }

        // Try to identify merchant from the host
        $host = request()->getHost();
        $appDomain = config('app.domain');

        // If we're on the main app domain, return null (no merchant context)
        if ($host === $appDomain) {
            return null;
        }

        // Check for custom domain
        $merchant = Merchant::where('domain', $host)->first();

        // If not found by domain, try subdomain
        if (!$merchant) {
            $hostParts = explode('.', $host);
            if (count($hostParts) > 1) {
                $subdomain = $hostParts[0];

                // Don't process 'www' as a subdomain
                if ($subdomain !== 'www') {
                    $merchant = Merchant::where('slug', $subdomain)->first();
                }
            }
        }

        // If merchant found, store it in the container
        if ($merchant) {
            app()->instance('currentMerchant', $merchant);
            return $merchant;
        }

        // No merchant found for this domain/subdomain
        return null;
    }

    public static function generateBreadCrumbs($currentPageName)
    {
        $prev_url          = Str::title(str_replace("_", " ",url()->previous()));
        $previous_basename = Str::title(basename(parse_url($prev_url, PHP_URL_PATH)));

        if (str_contains($previous_basename, 'login')) {
            $previous_basename = "Dashboard";
        }

        return "<div class='page-title-right'>
                <ol class='breadcrumb m-0'>
                    <li class='breadcrumb-item'><a href='{$prev_url}'>{$previous_basename}</a></li>
                    <li class='breadcrumb-item active'>{$currentPageName}</li>
                </ol>
            </div>";
    }

    /**
     * Get the settings for the application.
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public static function settings()
    {
        $settings = Setting::first();
        if (! $settings) {
            return null;
        }
        return $settings;
    }

    public static function getUserLucyRoseData($apiToken)
    {
        $client = new \GuzzleHttp\Client();

        dd($apiToken);

        try {
            $response = $client->request('GET', 'https://lucysrosedata.com/api/user/', [
                'headers' => [
                    'Authorization' => 'Token ' . $apiToken,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            return $data;

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return response()->json(['error' => 'Invalid API token or user not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching data.'], 500);
        }
    }

      /**
     * Render a menu by name or location
     *
     * @param mixed $merchant
     * @param string $location
     * @param string|null $name
     * @return string
     */
    public static function renderMenu($merchant, $location = 'header', $name = null)
    {
        // Get the menu by name or location
        $query = MerchantMenu::where('merchant_id', $merchant->id)
            ->where('is_active', true);

        if ($name) {
            $menu = $query->where('name', $name)->first();
        } else {
            $menu = $query->where('location', $location)->first();
        }

        if (!$menu) {
            return '';
        }

        // Get all menu items organized in a tree
        $menuItems = $menu->getTree();

        return view('components.menu', [
            'menuItems' => $menuItems,
            'merchant' => $merchant,
        ])->render();
    }
}
