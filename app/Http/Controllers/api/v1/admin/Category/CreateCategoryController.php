<?php

namespace App\Http\Controllers\api\v1\admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\category\CategoryRequest;
use Illuminate\Support\Facades\File;
use App\trait\image;
use App\trait\translaion;

use App\Models\category;

class CreateCategoryController extends Controller
{

    use image;
    use translaion;
    protected $categoryRequest = [
        'name',
        'ar_name',
        'tags',
        'category_id',
        'status',
        'order',
    ];

    public function create( CategoryRequest $request ){ 
        $data = $request->only($this->categoryRequest); // Get Request
        $image =  $this->upload($request,'thumbnail','admin/categories/thumbnail'); // Upload Thumbnail
        $data['thumbnail'] = $image;
        $this->translate($data['name'], $data['ar_name']);
        category::create($data);
        return response()->json([
            'success' => 'You Added Success',
            200
        ]);
    }

    public function modify( CategoryRequest $request, $id ){
        $data = $request->only($this->categoryRequest); // Get Request
        $category = category::where('id', $id)
        ->first(); //Get Category
        if (is_file($request->thumbnail)) { 
            $image =  $this->upload($request,'thumbnail','admin/categories/thumbnail'); // Upload Thumbnail
        
            // If new image is found delete old image
            if ( !empty($image) && $image != null ) { 
                $this->deleteImage($category->thumbnail); // Delete old Thumbnail
                $data['thumbnail'] = $image;
            }
        }

        $this->translate($data['name'], $data['ar_name']); // Translate Item
        $category->update($data); // Update Category
        return response()->json([
            'success' => 'You Updated Success',
            200
        ]);
    }

    public function delete( $id ){
        $category = category::where('id', $id)
        ->first(); //Get Category
        $this->deleteImage($category->thumbnail); // Delete old Thumbnail
        $category->delete(); // Update Category
        return response()->json([
            'success' => 'You Deleted Success',
            200
        ]);
    }

    
}
