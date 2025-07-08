<?php
namespace App\Services;

use App\Models\Percentage;
use App\Models\User;

abstract class BaseUtilityService
{
    protected $client;
    protected $settings;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    public function setSettings($settings): void
    {
        $this->settings = $settings;
    }

    abstract public function generateRequestId(): string;

    public function calculateFinalAmount(User $user, float $amount, string $serviceName): ?float
    {
        $percentage = Percentage::where('service', $serviceName)->first();

        if (! $percentage) {
            return null;
        }
        // User types
        $smart_earners   = $user->smart_earners;
        $topuser_earners = $user->topuser_earners;
        $api_earners     = $user->api_earners;

        if ($smart_earners == 1) {
            $smartEarnerPercent = $percentage->smart_earners_percent;
            $deduction          = ($smartEarnerPercent / 100) * $amount;
            $finalAmount        = $amount - $deduction;
        } elseif ($topuser_earners == 1) {
            $topuserEarnerPercent = $percentage->topuser_earners_percent;
            $deduction            = ($topuserEarnerPercent / 100) * $amount;
            $finalAmount          = $amount - $deduction;
        } elseif ($api_earners == 1) {
            $apiEarnerPercent = $percentage->api_earners_percent;
            $deduction        = ($apiEarnerPercent / 100) * $amount;
            $finalAmount      = $amount - $deduction;
        }
        return ceil($finalAmount);
    }
}