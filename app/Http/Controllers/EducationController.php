<?php

namespace App\Http\Controllers;

use App\Classes\Helper;
use Illuminate\Http\Request;
use App\Services\EducationService;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class EducationController extends Controller
{
    public $educationService;

    public function __construct(EducationService $educationService)
    {
        $this->educationService = $educationService;
        $merchantConfig = Helper::merchant();
        $preferences = $merchantConfig->preferences;
        $this->educationService->setSettings($preferences);
    }

     public function verifyEducation(Request $request)
    {
        // Validate the request
        $request->validate([
            'profile_id'  => 'required|numeric',
            'service' => 'required|string',
            'variation'      => 'required|string',
        ]);

        // Process the form data
        $billcode  = $request->input('profile_id');
        $serviceID = $request->input('service');
        $type      = $request->input('variation');

        // Set up API request data
        $data = [
            "billersCode" => $billcode,
            "serviceID"   => $serviceID,
            "type"        => $type,
        ];

        try {
            // Set up cURL config
            $response = $this->educationService->verifyJambProfile($data);

            $errorCodes = $this->educationService->getErrorCodes();
            $this->educationService->processVTPassVerifyResultForErrors($response, $errorCodes);

            // Return the result
            return response()->json([
                'status' => 'success',
                'message' => 'Verification successful',
                'data' => $response,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Return an error response with exception details
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}
