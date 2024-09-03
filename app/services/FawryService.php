<?php

namespace App\Services;

use GuzzleHttp\Client;

class FawryService
{
    
    protected $merchantCode;
    protected $securityKey;
    protected $baseUrl;
    protected $httpClient;

    public function __construct()
    {
        $this->merchantCode = config('services.fawry.merchant_code');
        $this->securityKey = config('services.fawry.security_key');
        $this->baseUrl = config('services.fawry.base_url');
        $this->httpClient = new Client();
    }

    /**
     * Generate signature for Fawry payment.
     *
     * @param array $paymentData
     * @return string
     */
    protected function generateSignature(array $paymentData)
    {
        $signatureString = $this->merchantCode .
                   $paymentData['merchantRefNum'] .
                   $paymentData['customerProfileId'] .
                   $paymentData['paymentMethod'] .
                   $paymentData['amount'] .
                   $paymentData['cardNumber'] .
                   $paymentData['cardExpiryYear'] .
                   $paymentData['cardExpiryMonth'] .
                   $paymentData['cvv'] .
                   $paymentData['returnUrl'] .
                   $this->securityKey;


                   $signature = hash('sha256', $signatureString);
                   return $signature;
    }

    /**
     * Process payment using Fawry.
     *
     * @param array $paymentData
     * @return array
     */
    public function chargePayment(array $paymentData)
    {
        // Generate signature
        $signature = $this->generateSignature($paymentData);

        // Prepare payload
        $payload = array_merge($paymentData, [
            'merchantCode' => $this->merchantCode,
            'signature' => $signature,
        ]);

        try {
            $response = $this->httpClient->post("{$this->baseUrl}/ECommerceWeb/Fawry/payments/charge", [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                ],
                'body' => json_encode($payload),
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            // Handle exceptions (e.g., log them)
            return ['error' => $e->getMessage()];
        }
    }
}
