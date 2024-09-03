<?php

namespace App\Http\Controllers\api\v1\admin\affilate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Payout;

class Aff_PayoutController extends Controller
{
    public function __construct(private Payout $payouts){}
    public function payouts(){
        $payouts = $this->payouts->where('status', null)
        ->orderBy('affilate_id')
        ->get();

        return response()->json([
            'payouts' => $payouts
        ]);
    }

    public function payouts_history(){
        $payouts = $this->payouts->where('status', '!=', null)
        ->orderBy('affilate_id')
        ->get();

        return response()->json([
            'payouts' => $payouts
        ]);
    }
}
