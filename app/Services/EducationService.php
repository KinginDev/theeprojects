<?php

    namespace App\Services;

    class EducationService extends BaseUtilityService
    {
        public function generateRequestId(): string
        {
            $current_time = new \DateTime('now', new \DateTimeZone('Africa/Lagos'));
            $formatted_time = $current_time->format("YmdHis");
            $additional_chars = "89htyyo";
            $request_id = $formatted_time . $additional_chars;

            while (strlen($request_id) < 12) {
                $request_id .= "x";
            }

            return $request_id;
        }


        public function verifyJambProfile($data){
            $requestId = $this->generateRequestId();
            $apiUrl = $this->settings->education_jamb_verify_api_url;

            $requiredParams = [
                'billersCode',
                'serviceID',
                'type',
            ];

            foreach ($requiredParams as $param) {
                if (!isset($data[$param])) {
                    throw new \Exception("Missing required parameter: $param");
                }
            }

            $result = $this->client->post($apiUrl, [
                'headers' => [
                    'api-key' => $this->settings->api_key,
                    'secret-key' => $this->settings->secret_key,
                    'Content-Type' => 'application/json',
                ],
                'json' => $data,
            ]);

            return json_decode($result->getBody()->getContents(), true);
        }
    }
