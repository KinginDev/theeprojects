<?php
namespace App\Services;

use GuzzleHttp\Client;

class AirtimeService extends BaseUtilityService
{
    protected $client;
    protected $settings;

    public function __construct()
    {
        $this->client = new Client();

    }

    public function setSettings($settings): void
    {
        $this->settings = $settings;
    }

    public function generateRequestId(): string
    {
        $time = now()->format('YmdHis');
        return str_pad($time . '89htyyo', 12, 'x');
    }

    public function purchaseAirtime(string $requestId, string $network, float $amount, string $phone, string $email): array
    {
        $response = $this->client->post($this->settings->airtime_api_url, [
            'headers' => [
                'api-key'      => $this->settings->api_key,
                'secret-key'   => $this->settings->secret_key,
                'Content-Type' => 'application/json',
            ],
            'json'    => [
                'request_id' => $requestId,
                'serviceID'  => $network,
                'amount'     => $amount,
                'phone'      => $phone,
                'email'      => $email,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function verifyTransaction(string $requestId): array
    {
        $response = $this->client->post($this->settings->transaction_api_url, [
            'headers' => [
                'api-key'      => $this->settings->api_key,
                'secret-key'   => $this->settings->secret_key,
                'Content-Type' => 'application/json',
            ],
            'json'    => ['request_id' => $requestId],
        ]);

        return json_decode($response->getBody(), true);
    }
}
