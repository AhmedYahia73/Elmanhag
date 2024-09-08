<?php

namespace App\Http\Controllers\api\v1\admin\discount;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Discount;
use App\Models\category;

class DiscountController extends Controller
{
    public function __construct(private Discount $discount,
    private category $categories){}
    public function show(){
        // https://bdev.elmanhag.shop/admin/discount
        $discounts = $this->discount
        ->with(['category', 'subject', 'bundle'])
        ->get();
        $categories = $this->categories->get();

        return response()->json([
            'discounts' => $discounts,
            'categories' => $categories
        ]);
    }
}
