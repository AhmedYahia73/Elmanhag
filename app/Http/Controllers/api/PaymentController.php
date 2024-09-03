<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Services\FawryService;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    protected $fawryService;

    public function __construct(FawryService $fawryService)
    {
        $this->fawryService = $fawryService;
    }

    /**
     * Handle payment request from mobile app.
     */
    public function charge(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'merchantRefNum' => ['required','string'],
            'customerProfileId' => ['required','string'],
            'paymentMethod' => ['required','string','in:CARD'],
            'amount' => ['required','numeric'],
            'cardNumber' => ['required','string'],
            'cardExpiryYear' => ['required','string'],
            'cardExpiryMonth' => ['required','string'],
            'cvv' => ['required','string'],
            'returnUrl' => ['required','url'],
            'customerName' => ['required','string'],
            'customerMobile' => ['required','string'],
            'customerEmail' => ['required','email'],
            'chargeItems' => ['required','array'],
            'chargeItems.*.itemId' => ['required','string'],
            'chargeItems.*.description' => ['required','string'],
            'chargeItems.*.price' => ['required','numeric'],
            'chargeItems.*.quantity' => ['required','integer'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Prepare payment data
        $paymentData = [
            'merchantRefNum' => $request->merchantRefNum,
            'customerProfileId' => $request->customerProfileId,
            'paymentMethod' => $request->paymentMethod,
            'amount' => $request->amount,
            'cardNumber' => $request->cardNumber,
            'cardExpiryYear' => $request->cardExpiryYear,
            'cardExpiryMonth' => $request->cardExpiryMonth,
            'cvv' => $request->cvv,
            'returnUrl' => $request->returnUrl,
            'customerName' => $request->customerName,
            'customerMobile' => $request->customerMobile,
            'customerEmail' => $request->customerEmail,
            'chargeItems' => $request->chargeItems,
            'currencyCode' => 'EGP',
            'language' => 'en-gb',
            'enable3DS' => true,
            'authCaptureModePayment' => false,
            'description' => 'Example Description',
        ];

        Log::info('Payment request data:', $paymentData);

        $response = $this->fawryService->chargePayment($paymentData);

        Log::info('Payment response data:', $response);

        return response()->json($response);
    }

    public function respose_payment(Request $request){
        return response()->json(
            [
                'request' => $request->all()
            ]
        );
    }
}
