<?php

namespace App\Http\Controllers\api\v1\admin\bundle;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\bundle;
use App\Models\Education;
use App\Models\subject;
use App\Models\category;

class BundleController extends Controller
{
    public function __construct(private category $categories){}
    public function show(){
        // https://bdev.elmanhag.shop/admin/bundle
        $bundles = bundle::
        with('category')
        ->with('subjects')
        ->with('discount')
        ->withCount('users')
        ->withCount('subjects')
        ->get();
        // Categories
        $categories = $this->categories->where('category_id', '!=', null)
        ->get();
        // Education
        $education = Education::get();
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
        $subjects = subject::get();


        return response()->json([
            'bundles' => $bundles,
            'education' => $education,
            'subjects' => $subjects,
            'categories' => $categories
        ]);
    }

    public function bundle_data($id){
        // https://bdev.elmanhag.shop/admin/bundle/{id}
        $bundle = bundle::
        with(['category', 'education', 'subjects'])
        ->first();

        return response()->json([
            'bundle' => $bundle
        ]);
    }
}
