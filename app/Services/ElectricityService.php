<?php
namespace App\Services;

use DateTime;
use DateTimeZone;
use GuzzleHttp\Client;
use App\Services\BaseUtilityService;

class ElectricityService extends BaseUtilityService
{

    public array $errorCodes = [
        '013' ,
        '014' ,
        '015' ,
        '016' ,
    ];

    public array $successCodes = [
        '000',
        '001',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function generateRequestId(): string
    {
        $time = now()->format('YmdHis');
        return str_pad($time . '89htyyo', 12, 'x');
    }

    // Additional methods for electricity service can be added here

    public function verifyMeterNumber($data)
    {
        $requiredProps = ['meter_number', 'service_name', 'type'];
        // Logic to verify the meter number
        // This is a placeholder; actual implementation will depend on the API or service used
        foreach ($requiredProps as $prop) {
            if (!isset($data[$prop])) {
                throw new \InvalidArgumentException("Missing required property: $prop");
            }
        }
        $meterNumber = $data['meter_number'] ?? '';
        $serviceName = $data['service_name'] ?? '';
        $type        = $data['type'] ?? '';

        $requestId = $this->generateRequestId();

         $payload = [
            'billersCode' => $meterNumber,
            'serviceID'   => $serviceName,
            'type'        => $type,
            'request_id'  => $requestId,
        ];

        $response = $this->client->post($this->settings->electricity_verify_api_url, [
            'headers' => ['api-key' => $this->settings->api_key,
                'secret-key'            => $this->settings->secret_key,
                'Content-Type'          => 'application/json',
            ],
            'json'    => $payload,
        ]);

        // Get the response body as a string
        $body = $response->getBody()->getContents();

        // Decode the JSON response
        return json_decode($body, true);
    }

    public function requestToken($data): array
    {
        $requestId = $this->generateRequestId();
        $payload = [
            'request_id'     => $requestId,
            'serviceID'      => $data['service_name'],
            'billersCode'    => $data['meter_number'],
            'variation_code' => $data['meter_type'] ,
            'amount'         => $data['amount'],
            "phone" => $data['tel'],
            "email" => $data['email']
        ];

        $response = $this->client->post($this->settings->electricity_pay_api_url, [
            'headers' => [
                'api-key'      => $this->settings->api_key,
                'secret-key'   => $this->settings->secret_key,
                'Content-Type' => 'application/json',
            ],
            'json'    => $payload,
        ]);

        return json_decode($response->getBody(), true);
    }
}
