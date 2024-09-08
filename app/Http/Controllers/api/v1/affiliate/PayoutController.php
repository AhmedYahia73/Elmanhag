<?php

namespace App\Http\Controllers\api\v1\affiliate;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\affiliate\PayoutRequest;
use App\Models\PaymentMethodAffilate;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    protected $payoutRequest = [
        'payment_method_affilate_id',
        'amount',
        'description',
        'date',
    ];
    public function __construct(private PaymentMethodAffilate $paymentMethodAffilate) {}
    // This Finction About All Payout For Affiliate Account

    public function payout(PayoutRequest $request)
    {
        $payout = $request->only($this->payoutRequest);
        $user = $request->user();
        $account = $user->income;
        $user_id = $user->id;
        $payout['user_id'] = $user_id;
        $payout['date'] = now();
        $method_id = $payout['payment_method_affilate_id'];
        $amountRequest = $payout['amount'];
        $affiliateWallet = $account->wallet;
        $paymentMethodAffiliate = $this->paymentMethodAffilate->where('id', $method_id)->first();
        $payoutMinLimit = $paymentMethodAffiliate->min_payout;
        if ($payoutMinLimit >= $amountRequest) {
            return response()->json([
                'faield' => 'Your Amount Less Than the amount specified for this payment method',
            ]);
        } elseif ($amountRequest > $affiliateWallet) {
            return response()->json([
                'faield' => 'Your Amount Less Than Your Wallet',
            ]);
        } 
        $newPayout = $user->payout_history()->create($payout);
        return response()->json([
        'success' => 'Payout Successfully',
        ]);
    }
}
