<?php
namespace App\Classes;

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
}
