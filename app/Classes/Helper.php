<?php
namespace App\Classes;

use App\Models\Setting;
use Illuminate\Support\Str;

class Helper
{
    public static function merchant()
    {
        $merchant = app('currentMerchant');
        if (! $merchant) {
            return null;
        }
        return $merchant;
    }

    public static function generateBreadCrumbs($currentPageName)
    {
        $prev_url          = url()->previous();
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
}
