<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\bundle;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\subject;
use App\Models\User;
use App\trait\PlaceOrder;
use Illuminate\Http\Request;
use App\services\FawryPayService;

class FawryPayController extends Controller
{
    protected $fawryPayService;

    public function __construct(
        private bundle $bundle,
        private subject $subject,
        private Payment $payment,
        private User $affiliate,
        private PaymentMethod $paymenty_method,
        FawryPayService $fawryPayService)
    {
        $this->fawryPayService = $fawryPayService;
    }
    use PlaceOrder; // This Trait For Make Order 
    public function payAtFawry(Request $request)
    {

        
         $request['customerProfileId'] = $request->user()->id ;
         $request['customerMobile'] = $request->user()->phone ;
        // Validate incoming request data
        $request->validate([
            // 'customerName' => 'required|string',
            'customerMobile' => 'required|string',
            // 'customerEmail' => 'required|email',
            'customerProfileId' => 'required|numeric',
            // 'merchantRefNum' => 'required|string',
            // 'amount' => 'required|numeric',
            // 'description' => 'required|string',
            'chargeItems' => 'required|array',
        ]);

             // Start Create Order If Operation Payment Success
           $placeOrder = $this->placeOrder($request);
             // Start Create Order If Operation Payment Success
       
        // Extract data
        $merchantRefNum = $request->merchantRefNum;
        $customerProfileId =$request->customerProfileId;
        $paymentMethod = 'PayAtFawry';
        $amount = $placeOrder['chargeItems']['price'];

        // Generate signature
        $signature = $this->fawryPayService->generateSignature($merchantRefNum, $customerProfileId, $paymentMethod, $amount);
        // Prepare the request payload
        $data = [
            'merchantCode' => env('FAWRY_MERCHANT_CODE'),
            'customerName' => $request->customerName,
            'customerMobile' => $request->customerMobile,
            'customerEmail' => $request->customerEmail,
            'customerProfileId' => $request->customerProfileId, // old Request => $request->customerProfileId Changed Cause When Pass Token I Will Get user_id
            'merchantRefNum' => $merchantRefNum,
            'amount' => number_format($placeOrder['chargeItems']['price'], 2, '.', ''),
            'paymentExpiry' => $request->paymentExpiry ?? null,
            'currencyCode' => 'EGP',
            'language' => $request->language ?? 'en-gb',
            'chargeItems' => [$placeOrder['chargeItems']],
            'signature' => $signature,
            'paymentMethod' => $paymentMethod,
            'description' => $request->description
        ];
 
        
            
        // Make the charge request
       $response = $this->fawryPayService->createCharge($data);
        // Return response to the client

   
        
        return response()->json($response);
    }

    public function checkPaymentStatus(Request $request)
{
    // Validate incoming request data
    $request->validate([
        'merchantRefNum' => 'required|string',
    ]);

    // Extract the reference number
    $merchantRefNum = $request->merchantRefNum;
                // Start Confirmation Order
                // Start Confirmation Order
                // Get payment status
                $response = $this->fawryPayService->getPaymentStatus($merchantRefNum);
                $this->confirmOrder($response);

    // Return response to the client
    return response()->json($response);
}

}
