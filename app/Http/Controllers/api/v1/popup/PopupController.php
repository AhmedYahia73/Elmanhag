<?php

namespace App\Http\Controllers\api\v1\popup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Popup;

class PopupController extends Controller
{
    public function __construct(private Popup $popup){}

    public function view(){
        // https://bdev.elmanhag.shop/api/popup
        $popups = $this->popup
        ->where('start_date', '<=', date('Y-m-d'))
        ->where('end_date', '>=', date('Y-m-d'))
        ->where('destination', auth()->user()->role)
        ->get();

        return response()->json([
            'popups' => $popups
        ], 200);
    }
}
