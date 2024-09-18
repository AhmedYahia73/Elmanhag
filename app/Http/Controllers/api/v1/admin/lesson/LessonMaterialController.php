<?php

namespace App\Http\Controllers\api\v1\admin\lesson;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\trait\image;

use App\Models\LessonResource;

class LessonMaterialController extends Controller
{
    use image;

    public function show( $lesson_id ){
        // https://bdev.elmanhag.shop/admin/lessonMaterial/{$lesson_id}
        $materials = LessonResource::where('lesson_id', $lesson_id)
        ->get(); 

        return response()->json([
            'materials' => $materials
        ]);
    }
    
    public function create( Request $request, $lesson_id ){
        // Keys
        // type ['voice', 'video', 'pdf'], source ['upload', 'external', 'embedded'], material
        // https://bdev.elmanhag.shop/admin/lessonMaterial/add/{$lesson_id}
 
        
        if(isset($request->materials)){
            foreach ($request->materials as $key => $item) {
                // if source file
                if ($item['source'] == 'upload') {
                    $file = $request->file("materials.$key.material");
                    $file_paths = $file->store('admin/lessons/' . $item['type'],'public'); // Store file in 'storage/app/uploads'
                    LessonResource::create([
                        'type' => $item['type'], 
                        'source' => $item['source'], 
                        'file' => $file_paths, 
                        'lesson_id' => $lesson_id,
                    ]);
                }
                else{
                    LessonResource::create([
                        'type' => $item['type'], 
                        'source' => $item['source'], 
                        'file' => $item['material'], 
                        'lesson_id' => $lesson_id,
                    ]);
                }
            } 
        }
        // // Add Source
        // if ( $request->source == 'upload' ) {
        //     // Upload file
        //     $path = $this->upload($request, 'material', 'admin/lessons/' . $request->type);
        //     // Create lesson source
        //     LessonResource::create([
        //         'type' => $request->type,
        //         'source' => $request->source,
        //         'file' => $path,
        //         'lesson_id' => $lesson_id,
        //     ]); 
        // }
        // else{
        //     // Create lesson source
        //     LessonResource::create([
        //         'type' => $request->type,
        //         'source' => $request->source,
        //         'file' => $request->material,
        //         'lesson_id' => $lesson_id,
        //     ]); 
        // }

        return response()->json([
            'success' => 'You add data success'
        ]);
    }
    
    public function delete( $id ){
        // https://bdev.elmanhag.shop/admin/lessonMaterial/delete/{id}
        // Get lesson material
        $material = LessonResource::
        where('id', $id)
        ->first();
        // delete image of material
        $this->deleteImage($material->file);
        // delete material
        $material->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
