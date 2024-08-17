<?php

namespace App\Http\Controllers\api\v1\admin\bundle;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\bundle;

class BundleController extends Controller
{
    public function show(){
        // https://bdev.elmanhag.shop/admin/bundle
        $bundles = bundle::
        with('category')
        ->with('discount')
        ->withCount('users')
        ->withCount('subjects')
        ->get();
        foreach ($bundles as $bundle) {
            // Manually add price after discount
            foreach ($bundle->discount as $discount) {
                if ( $discount->type == 'precentage' ) {
                    $bundle->price_discount = $bundle->price - ($bundle->price * $discount->amount / 100);
                } else {
                    $bundle->price_discount = $bundle->price - $discount->amount;
                }
                break;
            }
        }

        return response()->json([
            'bundles' => $bundles
        ]);
    }
}
