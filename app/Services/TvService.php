<?php

namespace App\Services;

use DateTime;
use DateTimeZone;
use App\Models\User;
use App\Enums\ProductTypes;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TvTransaction;
use App\Models\WalletTransaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TvService extends BaseUtilityService
{


    protected array $serviceMap = [
        'dstv'      => 'Dstv_Payment',
        'gotv'      => 'Gotv_Payment',
        'startimes' => 'Startimes_Payment',
        'showmax'   => 'Showmax_Payment',
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

    /**
     * Get service name from service ID
     *
     * @param string $serviceId
     * @return string|null
     */
    public function getServiceName(string $serviceId): ?string
    {
        return $this->serviceMap[$serviceId] ?? null;
    }

    /**
     * Get product by service name
     *
     * @param string $serviceId
     * @return Product|null
     */
    public function getProductByServiceId(string $serviceId): ?Product
    {
        $serviceName = $this->getServiceName($serviceId);
        if (!$serviceName) {
            return null;
        }

        return Product::where('type', ProductTypes::TV->value)
            ->where('service_name', $serviceName)->first();
    }

    /**
     * Verify TV biller code
     *
     * @param array $data
     * @return array
     * @throws \InvalidArgumentException
     */
    public function verifyBillerCode(array $data)
    {
        $requiredProps = ['billers_code', 'service_name'];
        // Logic to verify the biller code
        foreach ($requiredProps as $prop) {
            if (!isset($data[$prop])) {
                throw new \InvalidArgumentException("Missing required property: $prop");
            }
        }
        $billersCode = $data['billers_code'] ?? '';
        $serviceName = $data['service_name'] ?? '';

        $requestId = $this->generateRequestId();

        $payload = [
            'billersCode' => $billersCode,
            'serviceID'  => $serviceName,
            'request_id' => $requestId,
        ];

        $response = $this->client->post($this->settings->tv_billcode_api_url, [
            'headers' => [
                'api-key'      => $this->settings->api_key,
                'secret-key'   => $this->settings->secret_key,
                'Content-Type' => 'application/json',
            ],
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Change or renew TV bouquet
     *
     * @param array $data
     * @return array
     * @throws \InvalidArgumentException
     */
    public function changeBouquet(array $data)
    {
        $requestId = $this->generateRequestId();

        $data['request_id'] = $requestId;


        $response = $this->client->post($this->settings->tv_bouquet_api_url, [
            'headers' => [
                'api-key'      => $this->settings->api_key,
                'secret-key'   => $this->settings->secret_key,
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Create transactions for TV purchase/renewal
     *
     * @param User $user
     * @param array $validatedData
     * @param array $result
     * @param float $userBalance
     * @param float $finalAmount
     * @param array $otherData
     * @return array
     */
    public function createTvTransactions(User $user, array $validatedData, array $result, float $userBalance, float $finalAmount, array $otherData)
    {
        $purchaseCode = $result['purchased_code'] ?? $result['token'] ?? null;
        $requestId    = $result['requestId'] ?? $result['request_id'] ?? null;
        $phone        = $user->phone ?? $validatedData['tel'];
        $email        = $user->email;
        $amount       = $otherData['amount'] ?? $validatedData['amount'];
        $percentProfit = $otherData['percent_profit'] ?? 0;

        $billersCode       = $validatedData['billers_code'] ?? $validatedData['billersCode'] ?? '';
        $subscription_type = $validatedData['subscription_type'] ?? $validatedData['bouquetAction'] ?? '';
        $serviceName       = $otherData['service_name'] ?? '';

        // Create main transaction record
        $transaction = Transaction::create([
            'transactable_type' => User::class,
            'transactable_id'   => $user->id,
            'amount'            => $amount,
            'type'              => ProductTypes::TV->value,
            'description'       => 'TV purchase for ' . $billersCode,
            'kind'              => 'debit',
            'status'            => 'success',
            'payload'           => [
                'billers_code'      => $billersCode,
                'subscription_type' => $subscription_type,
                'email'             => $email,
                'tel'               => $phone,
            ],
            'reference'         => $requestId,
            'provider_reference' => $purchaseCode,
        ]);

        // Calculate new balance
        $currentBal = $userBalance - $amount;

        // Update user's wallet balance
        $user->wallet->update(['balance' => $currentBal]);

        // Create wallet transaction
        WalletTransaction::create([
            'wallet_owner_id'   => $user->id,
            'wallet_owner_type' => User::class,
            'wallet_id'         => $user->wallet->id,
            'transaction_id'    => $transaction->getKey(),
            'amount'            => $amount,
            'type'              => 'debit',
            'description'       => Str::title($serviceName) . ' subscription ' . $subscription_type . ' for ' . $billersCode,
            'prev_balance'      => $userBalance,
            'current_balance'   => $currentBal,
        ]);

        // Create TV transaction record
        TvTransaction::create([
            'username'       => $user->username,
            'api_response'   => $result['response_description'] ?? 'No description provided',
            'network'        => $serviceName,
            'tel'            => $phone,
            'plan'           => $subscription_type,
            'amount'         => $amount,
            'reference'      => $requestId,
            'identity'       => $result['content']['transactions']['product_name'] ?? 'Unknown Product',
            'prev_bal'       => $userBalance,
            'current_bal'    => $currentBal,
            'percent_profit' => $percentProfit,
            'status'         => 'successful',
        ]);

        return [
            'transaction'  => $transaction,
            'purchaseCode' => $purchaseCode,
        ];
    }

    /**
     * Process TV purchase transaction
     *
     * @param User $user
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function processTvPurchase(User $user, array $data)
    {
        // Get product from service name
        $product = $this->getProductByServiceId($data['service_name']);
        if (!$product) {
            throw new \Exception('Invalid service selected');
        }

        // Verify user wallet status and calculate final amount
        $walletData = $this->validateWalletAndCalculateFinalAmount($user, $data['amount'], $product->slug);
        $userBalance = $walletData['userBalance'];
        $finalAmount = $walletData['finalAmount'];
        $percentProfit = $walletData['percentProfit'];

        // Set up purchase data
        $purchaseData = [
            "serviceID"      => $data['service_name'],
            "billersCode"      => $data['billersCode'],
            "amount"            => $data['amount'],
            "phone"      => $data['tel'],
            "quantity"          => $data['quantity'] ?? 1,
            "subscription_type" => $data['subscription_type'],
            'variation_code'    => $data['variation_code'] ?? '',
        ];

        // Make the API call
        $result = $this->changeBouquet($purchaseData);
        // Process API result for errors
        $this->processVTPassPurchaseResultForErrors($result, $this->errorCodes);

        // Create transactions
        $transactionResult = $this->createTvTransactions($user, $data, $result, $userBalance, $finalAmount, [
            'amount'        => $finalAmount,
            'service_name'  => $product->service_name,
            'percent_profit' => $percentProfit,
        ]);

        return [
            'status'  => 'success',
            'data'    => $result,
            'amount'  => $data['amount'],
            'transaction' => $transactionResult,
            'billers_code' => $data['billersCode'],
            'variation_code' => $data['variation_code'] ?? null,
            'message' => Str::upper($product->service_name) . ' Subscription successful',
        ];
    }

    /**
     * Validate user wallet status and calculate final amount
     *
     * @param User $user
     * @param float $amount
     * @param string $serviceSlug
     * @return array
     * @throws \Exception
     */
    private function validateWalletAndCalculateFinalAmount(User $user, float $amount, string $serviceSlug): array
    {
        // Get user wallet balance
        $userBalance = $user->wallet->balance;

        // Calculate final amount after discounts
        $finalAmount = $this->calculateFinalAmount($user, $amount, $serviceSlug);
        if ($finalAmount === null) {
            throw new \Exception('Could not calculate final amount');
        }

        // Check sufficient balance
        if ($userBalance < $finalAmount) {
            throw new \Exception('Insufficient balance, please recharge your wallet');
        }

        return [
            'userBalance' => $userBalance,
            'finalAmount' => $finalAmount,
            'percentProfit' => $amount - $finalAmount,
        ];
    }
}
