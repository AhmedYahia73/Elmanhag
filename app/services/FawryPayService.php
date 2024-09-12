<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FawryPayService
{
    protected $merchantCode;
    protected $secureKey;
    protected $apiUrl;
    protected $verifySSL;

    public function __construct()
    {
        // Load environment variables
        $this->merchantCode = env('FAWRY_MERCHANT_CODE');  // Set in .env
        $this->secureKey = env('FAWRY_SECURE_KEY');  // Set in .env
        $this->apiUrl = 'https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/charge';  // Staging API URL

        // Check if SSL verification is needed
        $this->verifySSL = env('APP_ENV') === 'production';  // Verify SSL in production, ignore in other environments
    }

    /**
     * Generate a signature for the FawryPay request
     *
     * @param string $merchantRefNum
     * @param string $customerProfileId
     * @param string $paymentMethod
     * @param float  $amount
     * @return string
     */
    public function generateSignature($merchantRefNum, $customerProfileId, $paymentMethod, $amount)
    {
        // Format the amount to two decimal places
        $formattedAmount = number_format($amount, 2, '.', '');

        // Concatenate the required values for the signature
        $signatureData = $this->merchantCode . $merchantRefNum . $customerProfileId . $paymentMethod . $formattedAmount . $this->secureKey;

        // Generate SHA-256 signature
        return hash('sha256', $signatureData);
    }

    /**
     * Create a charge request to FawryPay
     *
     * @param array $data
     * @return array|null
     */
    public function createCharge($data)
    {
        try {
            // Make the POST request to FawryPay API with SSL verification based on environment
            $response = Http::withOptions([
                'verify' => false, // SSL verification in production only
            ])->post($this->apiUrl, $data);

            // Log the response for debugging
            Log::info('FawryPay Response: ', ['response' => $response->json()]);

            // Return the response as JSON
            return $response->json();

        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('FawryPay Error: ', ['error' => $e->getMessage()]);

            // Optionally, you can return an error response to the calling method
            return [
                'statusCode' => 500,
                'statusDescription' => 'Internal Server Error',
                'error' => $e->getMessage()
            ];
        }
    }

    public function getPaymentStatus($merchantRefNumber)
{
    try {
        // Generate the signature
        $signature = hash('sha256', $this->merchantCode . $merchantRefNumber . $this->secureKey);

        // Make the GET request to FawryPay API
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/status/v2', [
            'merchantCode' => $this->merchantCode,
            'merchantRefNumber' => $merchantRefNumber,
            'signature' => $signature
        ]);

        // Log the response for debugging
        Log::info('FawryPay Payment Status Response: ', ['response' => $response->json()]);

        // Return the response as JSON
        return $response->json();

    } catch (\Exception $e) {
        // Log the error for debugging purposes
        Log::error('FawryPay Payment Status Error: ', ['error' => $e->getMessage()]);

        // Optionally, return an error response
        return [
            'statusCode' => 500,
            'statusDescription' => 'Internal Server Error',
            'error' => $e->getMessage()
        ];
    }
}

}

