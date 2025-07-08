<?php

namespace App\Services;

use App\Models\User;
use GuzzleHttp\Client;

class DataService extends BaseUtilityService
{
    protected $client;
    protected $settings;
    protected $serviceMap = [
        4 => [
            'CORPORATE GIFTING' => 'Airtel_CORPORATE_GIFTING_Data',
            'GIFTING' => 'Airtel_GIFTING_Data',
        ],
        1 => [
            'SME' => 'MTN_SME_Data',
            'SME 2' => 'MTN_SME2_Data',
            'CORPORATE GIFTING' => 'MTN_CORPORATE_GIFTING_Data',
            'GIFTING' => 'MTN_GIFTING_Data',
        ],
        2 => [
            'GIFTING' => 'GLO_GIFTING_Data',
            'CORPORATE GIFTING' => 'GLO_CORPORATE_GIFTING_Data',
        ],
        6 => [
            'GIFTING' => '9mobile_GIFTING_Data',
            'CORPORATE GIFTING' => '9mobile_CORPORATE_GIFTING_Data',
        ]
    ];

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
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

    public function getLucyRoseNetworkData($body = null)
    {
        $response = $this->client->get("https://lucysrosedata.com/api/network/", [
            'headers' => [
                'Authorization' => 'Token ' . $this->settings->site_token,
                'Content-Type' => 'application/json',
            ],
            'json' => $body
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getServiceName(int $network, string $networkType): ?string
    {
        return $this->serviceMap[$network][$networkType] ?? null;
    }

    public function purchaseData(string $requestId, int $network, string $networkType, string $phoneNumber, string $plan, float $amount)
    {
        $apiUrl = $this->settings->data_network_api_url;

        $data = [
            "request_id" => $requestId,
            "serviceID" => strtolower($this->getNetworkName($network)) . "-data",
            "billersCode" => $phoneNumber,
            "variation_code" => $plan,
            "amount" => $amount,
            "phone" => $phoneNumber,
        ];

        $response = $this->client->get($apiUrl, [
            'headers' => [
                'Authorization' => "Token ". $this->settings->site_token,
                'Content-Type' => 'application/json',
            ],

        ]);

        return json_decode($response->getBody(), true);
    }



    public function getNetworkName(int $network): string
    {
        return match ($network) {
            1 => 'mtn',
            2 => 'glo',
            4 => 'airtel',
            6 => '9mobile',
            default => throw new \InvalidArgumentException('Invalid network ID'),
        };
    }

    /**
     * Process data gifting purchase for MTN and Airtel
     *
     * @param array $data Request data containing network, type, phone, and amount
     * @param User $user Authenticated user
     * @return array
     */
    public function processDataGiftingPurchase(array $data, User $user)
    {

            $networkId = (int)$data['network'];
            $networkName = $this->getNetworkName($networkId);

            // Get the service name for gifting
            $serviceName = $this->getServiceName($networkId, 'GIFTING');
            if (!$serviceName) {
                return ['status' => 'failed', 'message' => 'Invalid network or service type'];
            }

            // Calculate final amount with user-specific deductions
            $finalAmount = $this->calculateFinalAmount($user, (float)$data['amount'], $serviceName);
            if ($finalAmount === null) {
                return ['status' => 'failed', 'message' => 'Could not calculate final amount'];
            }

            // Check balance
            if ($user->wallet->balance < $finalAmount) {
                return ['status' => 'failed', 'message' => 'Insufficient funds'];
            }

            // Generate request ID
            $requestId = $this->generateRequestId();


            $apiUrl        = $this->settings->airtime_api_url;

            // Make API call to purchase data
            $purchaseResult = $this->client->post($apiUrl, [
                'headers'=> [
                    "api-key" => $this->settings->api_key,
                    "secret-key" => $this->settings->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'request_id' => $requestId,
                    'serviceID' => strtolower($this->getNetworkName($networkId)) . "-data",
                    'billersCode' => $data['tel'],
                    'variation_code' => $data['type'],
                    'amount' => $finalAmount,
                    'phone' => $data['tel'],
                ]
            ]);



           return json_decode($purchaseResult->getBody(), true);

    }

    /**
     * Get data variations for MTN and Airtel networks
     *
     * @param int $networkId
     * @param User $user
     * @return array
     */
    public function getDataVariations(int $networkId, User $user): array
    {
        try {
            if (!in_array($networkId, [1, 4])) {
                return ['status' => 'failed', 'message' => 'Invalid network selected'];
            }

            // Get service name
            $serviceName = $this->getServiceName($networkId, 'GIFTING');
            if (!$serviceName) {
                return ['status' => 'failed', 'message' => 'Invalid service mapping'];
            }

            // Get percentage settings
            $percentage = \App\Models\Percentage::where('service', $serviceName)->first();
            if (!$percentage) {
                return ['status' => 'failed', 'message' => 'Service percentage not found'];
            }

            // Determine profit percentage based on user type
            $profitPercentage = null;
            if ($user->smart_earners) {
                $profitPercentage = $percentage->smart_earners_percent;
            } elseif ($user->topuser_earners) {
                $profitPercentage = $percentage->topuser_earners_percent;
            } elseif ($user->api_earners) {
                $profitPercentage = $percentage->api_earners_percent;
            }

            if ($profitPercentage === null) {
                return ['status' => 'failed', 'message' => 'No valid earner type found'];
            }

            // Get appropriate API URL based on network
            $apiUrl = $networkId == 1 ? $this->settings->data_mtn : $this->settings->data_airtime;

            // Make API request
            $response = $this->client->get($apiUrl, [
                'headers' => [
                    'api-key' => $this->settings->api_key,
                    'secret-key' => $this->settings->secret_key,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $result = json_decode($response->getBody(), true);

            if (empty($result)) {
                return ['status' => 'failed', 'message' => 'No data variations available'];
            }

            return [
                'status' => 'success',
                'data' => $result,
                'profitPercentage' => $profitPercentage
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'failed',
                'message' => 'Error fetching data variations',
                'error' => $e->getMessage()
            ];
        }
    }
}
