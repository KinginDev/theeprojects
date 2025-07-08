<?php
namespace App\Services;

class ElectricityService extends BaseUtilityService
{


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

        $payload = [
            'billersCode' => $meterNumber,
            'serviceID'   => $serviceName,
            'type'        => $type,
        ];

        $response = $this->client->post($this->settings->electricity_verify_api_url, [
            'headers' => ['api-key' => $this->settings->api_key,
                'secret-key'            => $this->settings->secret_key,
                'Content-Type'          => 'application/json',
            ],
            'json'    => $payload,
        ]);
        return json_encode($response->getBody(), true);
    }

    public function requestToken($data): array
    {
        $requestId = $this->generateRequestId();
        $payload = [
            'request_id'     => $requestId,
            'serviceID'      => $data['serviceID'],
            'billersCode'    => $data['billersCode'],
            'variation_code' => $data['variation_code'],
            'amount'         => $data['amount'],
            "phone" => $data['tel'],
            "email" => $data['email']
        ];

        $response = $this->client->post($this->settings->electricity_api_url, [
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
