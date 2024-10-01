<?php

namespace App\Http\Controllers\api\v1\admin\popup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Popup;

class PopupController extends Controller
{
    public function __construct(private Popup $popup){}

    public function show(){
        // https://bdev.elmanhag.shop/admin/popup
        $popups = $this->popup
        ->get();

        return response()->json([
            'popups' => $popups
        ]);
    }
}
