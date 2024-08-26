<?php

namespace App\Http\Controllers\api\v1\admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Requests\api\admin\category\CategoryRequest;

use App\Models\category;

class CategoryController extends Controller
{
    public function __construct(private category $category){}
    public function show(){
        // Category data with parent
        $categories = $this->category
        ->with('parent_category')
        ->orderBy('category_id')
        ->get();
        $parent_categories = $this->category
        ->where('category_id', null)
        ->get();

        return response()->json([
            'categories' => $categories,
            'parent_categories' => $parent_categories
        ]);
    }

}
