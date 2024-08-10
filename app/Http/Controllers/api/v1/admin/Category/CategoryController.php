<?php

namespace App\Http\Controllers\api\v1\admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Requests\api\admin\category\CategoryRequest;

use App\Models\category;

class CategoryController extends Controller
{
    public function show(){
        // Category data with parent
        $categories = category::
        with('parent_category')
        ->orderBy('category_id')
        ->get();

        return response()->json([
            'categories' => $categories
        ]);
    }

}
