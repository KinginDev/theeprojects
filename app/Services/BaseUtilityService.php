<?php
namespace App\Services;

use App\Models\Percentage;
use App\Models\User;

abstract class BaseUtilityService
{
    protected $client;
    protected $settings;

    public array $errorCodes = [
        '013',
        '014',
        '015',
        '016',
        "011",
    ];

    public array $successCodes = [
        '000',
        '001',
    ];

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    public function setSettings($settings): void
    {
        $this->settings = $settings;
    }

    public function getErrorCodes(): array
    {
        return $this->errorCodes;
    }

    public function setErrorCodes(array $errorCodes): void
    {
        $this->errorCodes = $errorCodes;
    }

    public function addErrorCode(string $errorCode): void
    {
        if (!in_array($errorCode, $this->errorCodes)) {
            $this->errorCodes[] = $errorCode;
        }
    }

    public function getSuccessCodes(): array
    {
        return $this->successCodes;
    }
    public function setSuccessCodes(array $successCodes): void
    {
        $this->successCodes = $successCodes;
    }

    abstract public function generateRequestId(): string;

    public function calculateFinalAmount(User $user, float $amount, string $serviceSlug): ?float
    {
        $percentage = Percentage::where('service', $serviceSlug)->first();


        if (! $percentage) {
            return null;
        }
        // User types
        $smart_earners   = $user->smart_earners;
        $topuser_earners = $user->topuser_earners;
        $api_earners     = $user->api_earners;

        if ($smart_earners == 1) {
            $smartEarnerPercent = $percentage->smart_earners_percent;
            $smartEarnerPercent = preg_replace('/%/', '', $smartEarnerPercent);
            $deduction          = ($smartEarnerPercent / 100) * $amount;
            $finalAmount        = $amount - $deduction;
        } elseif ($topuser_earners == 1) {
            $topuserEarnerPercent = $percentage->topuser_earners_percent;
            $topuserEarnerPercent = preg_replace('/%/', '', $topuserEarnerPercent);
            $deduction            = ($topuserEarnerPercent / 100) * $amount;
            $finalAmount          = $amount - $deduction;
        } elseif ($api_earners == 1) {
            $apiEarnerPercent = $percentage->api_earners_percent;
            $apiEarnerPercent = preg_replace('/%/', '', $apiEarnerPercent);
            $deduction        = ($apiEarnerPercent / 100) * $amount;
            $finalAmount      = $amount - $deduction;
        }
        return ceil($finalAmount);
    }

    public function processVTPassPurchaseResultForErrors($result, array $errorCodes){
         if (isset($result['code']) && in_array($result['code'], $errorCodes)) {
            $message = $result['response_description'] ?? "Purchase failed: Please try again later";

            throw new \Exception($message);
        }

        if (!isset($result['content']['transactions']) ||
            (isset($result['content']['transactions']) && $result['content']['transactions']['status'] == "failed")) {

            $message = $result['response_description'] ?? $result['content']['errors'] ?? 'Unknown error';
            throw new \Exception($message);

        }

        return $result;
    }

      public function processVTPassVerifyResultForErrors($result, array $errorCodes){
         if (isset($result['code']) && in_array($result['code'], $errorCodes)) {
            $message = $result['response_description'] ?? "Verification: Please try again later";

            throw new \Exception($message);
        }
        if(isset($result['content']['error']) || isset($result['content']['errors'])) {
            // Return error response
            throw new \Exception($result['content']['error'] ?? $result['content']['errors'][0]);
        }

        return $result;
    }
}
