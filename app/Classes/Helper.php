<?php
namespace App\Classes;

class Helper
{
    public static function merchant()
    {
        return app('currentMerchant');
    }
}
