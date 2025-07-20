<?php
namespace App\Http\Controllers\User;

use App\Models\User;
use App\Classes\Helper;
use App\Services\TvService;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TvController extends Controller
{
    public TvService $tvService;

    public function __construct(TvService $tvService)
    {
        $this->tvService = $tvService;
        $preferences = Helper::merchant()->preferences;
        $this->tvService->setSettings($preferences);
    }

    /**
     * Show TV dashboard
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function indexTv()
    {
        $user = Auth::user();

        if ($user) {
            // Retrieve all data for the user from the database
            $userData = User::where('id', $user->id)->first();
            $notifications = Notification::where('username', $user->username)->get();

            return view('users-layout.dashboard.tv', [
                'userData'      => $userData,
                'notifications' => $notifications,
            ]);
        }

        // Redirect if no user is authenticated
        return redirect()->route('login');
    }

    /**
     * Verify TV smart card number
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifySmartCardNumber(Request $request)
    {
        // Validate the request
        $request->validate([
            'billersCode'  => 'required|string',
            'service_name' => 'required|string',
        ]);

        try {
            $data = [
                'billers_code' => $request->input('billersCode'),
                'service_name' => $request->input('service_name'),
            ];

            // Verify smart card number via service
            $result = $this->tvService->verifyBillerCode($data);
            $this->tvService->processVTPassVerifyResultForErrors($result, $this->tvService->errorCodes);

            // Return success response
            return response()->json([
                'status'  => 'success',
                'message' => 'Smart Card verification successful',
                'data'    => $result['content'],
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'status'  => 'failed',
                'message' => $e->getMessage(),
                'error'   => true,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Purchase or renew TV bouquet
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function purchaseRenewBouquet(Request $request)
    {

        // Validate the request
        $validated = $request->validate([
            'tel'           => 'required|numeric',
            'service_name'  => 'required|string',
        ]);


        switch ($validated['service_name']) {
            case 'showmax':
                $validated['billersCode'] = $request->input('tel');
                $validated['bouquetAction'] = $request->input('bouquetAction');
                $validated['selectedBouquet'] = $request->input('selectedBouquet', '');
                $validated['amount'] = $request->input('amount', 0);
                break;
            case 'startimes':
                $validated['billersCode'] = $request->input('tel');
                $validated['bouquetAction'] = $request->input('bouquetAction');
                $validated['selectedBouquet'] = $request->input('selectedBouquet', '');
                $validated['amount'] = $request->input('amount', 0);
                break;
            case 'gotv':
            case 'dstv':
            default:
                 $validated['billersCode'] = $request->input('billerCode');
                 $validated['bouquetAction'] = $request->input('bouquetAction');
                 $validated['selectedBouquet'] = $request->input('selectedBouquet', '');
                 $validated['amount'] = $request->input('amount', 0);
                 break;
        }

        try {
            DB::beginTransaction();

            // Prepare data for service
            $processData = [
                'service_name'      => $validated['service_name'],
                'billersCode'       => $validated['billersCode'],
                'billers_code'      => $validated['billersCode'], // Add both versions for compatibility
                'variation_code'    => $validated['selectedBouquet'] ?? '',
                'amount'            => $validated['amount'] ?? 0,
                'tel'               => $validated['tel'],
                'subscription_type' => $validated['bouquetAction'],
                'bouquetAction'     => $validated['bouquetAction'], // Add both versions for compatibility
                'quantity'          => 1,
            ];

            // Process purchase via service
            $user = Auth::guard('web')->user();
            $result = $this->tvService->processTvPurchase($user, $processData);

            DB::commit();

            // Return success response
            return response()->json([
                'status'  => $result['status'],
                'message' => $result['message'],
                'data'    => $result['data'],
                'token'   => $result['transaction']['purchaseCode'] ?? null,
                'amount'  => $result['amount'] ?? null,
                'billers_code' => Str::title($result['billers_code']) ?? null,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            DB::rollBack();

            // Return error response
            return response()->json([
                'status'  => 'failed',
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Legacy method for renewing bouquet - refactored to use service
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function renewBouquet(Request $request)
    {
        // Validate the request
        $request->validate([
            'billerCode' => 'required|integer',
            'bouquet'    => 'required|string',
            'tel'        => 'required|numeric',
            'amount'     => 'required|numeric',
            'serviceId'  => 'required|string',
        ]);

        try {
            // Prepare data for service
            $processData = [
                'service_name'      => $request->input('serviceId'),
                'billersCode'       => $request->input('billerCode'),
                'billers_code'      => $request->input('billerCode'), // Add both versions for compatibility
                'variation_code'    => '', // Not needed for renewal
                'amount'            => $request->input('amount'),
                'tel'               => $request->input('tel'),
                'subscription_type' => $request->input('bouquet'),
                'bouquet'           => $request->input('bouquet'), // Add both versions for compatibility
                'quantity'          => 1,
            ];

            // Process purchase via service
            $user = Auth::user();
            $result = $this->tvService->processTvPurchase($user, $processData);

            // Return success response
            return response()->json([
                'status'  => $result['status'],
                'message' => $result['message'],
                'data'    => $result['data'],
                'token'   => $result['transaction']['purchaseCode'] ?? null,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'status'  => 'failed',
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
