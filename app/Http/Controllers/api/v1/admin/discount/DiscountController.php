<?php

namespace App\Http\Controllers\api\v1\admin\discount;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Discount;

class DiscountController extends Controller
{
    public function __construct(private Discount $discount){}
    public function show(){

    }
}
