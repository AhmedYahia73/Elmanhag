<?php

namespace App\Http\Controllers\api\v1\admin\discount;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Discount;
use App\Models\category;
use App\Models\subject;
use App\Models\bundle;

class DiscountController extends Controller
{
    public function __construct(private Discount $discount,
    private category $categories, private subject $subjects, private bundle $bundles){}
    public function show(){
        // https://bdev.elmanhag.shop/admin/discount
        $discounts = $this->discount
        ->with(['category', 'subject', 'bundle'])
        ->get();
        $categories = $this->categories
        ->where('category_id', '!=', null)
        ->get();
        $subjects = $this->subjects->get();
        $bundles = $this->bundles->get();

        return response()->json([
            'discounts' => $discounts,
            'categories' => $categories,
            'subjects' => $subjects,
            'bundles' => $bundles,
        ]);
    }
}
