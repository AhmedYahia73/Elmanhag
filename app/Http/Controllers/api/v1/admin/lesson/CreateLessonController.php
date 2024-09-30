<?php

namespace App\Http\Controllers\api\v1\admin\lesson;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\trait\image;
use App\trait\translaion;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\api\admin\lesson\LessonRequest;

use App\Models\lesson;
use App\Models\LessonResource;

class CreateLessonController extends Controller
{
    use image;
    use translaion;
    protected $lessonRequest = [
        'name',
        'ar_name',
        'description',
        'paid',
        'status',
        'switch',
        'order',
        'drip_content',
        'chapter_id',
    ];

    public function lesson($id){
        // https://bdev.elmanhag.shop/admin/lesson/{id}
        $lesson = lesson::
        where('id', $id)
        ->first();

        return response()->json([
            'lesson' => $lesson
        ]);
    }

    public function create( LessonRequest $request, $ch_id ){
        // https://bdev.elmanhag.shop/admin/lesson/add/{chapter_id}  
        // Keys 
        // name, ar_name, description, paid, status, order, drip_content, switch
        // materials [{type, source, material}]
        $lesson_data = $request->only($this->lessonRequest); // Get data
        $lesson_data['chapter_id'] = $ch_id;
        $this->translate($lesson_data['name'], $lesson_data['ar_name']); // Translate at file json
        $lesson = lesson::create($lesson_data); // Create lesson record

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
                        'lesson_id' => $lesson->id,
                    ]);
                }
                else{
                    LessonResource::create([
                        'type' => $item['type'], 
                        'source' => $item['source'], 
                        'file' => $item['material'], 
                        'lesson_id' => $lesson->id,
                    ]);
                }
            } 
        }
    

        return response()->json([
            'success' => $request->all()
        ]);
    }

    public function switch(Request $request, $id){
        // https://bdev.elmanhag.shop/admin/lesson/switch/{id}
        $validator = Validator::make($request->all(), [
            'switch' => 'required',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
        lesson::where('id', $id)
        ->update([
            'switch' => $request->switch
        ]);

        return response()->json([
            'success' => 'You make proccess success'
        ]);
    }

    public function modify( LessonRequest $request, $id ){
        // https://bdev.elmanhag.shop/admin/lesson/update/{id}
        //Keys 
        // name, ar_name, description, paid, status, order, drip_content, switch
        // voice[], voice_source[]
        // video_source[], video[]
        // pdf_source[], pdf[]
        $lesson_data = $request->only($this->lessonRequest); // Get data
        $lesson = lesson::where('id', $id)
        ->first();
        $this->translate($lesson_data['name'], $lesson_data['ar_name']); // Translate at file json
        $lesson->update($lesson_data);
        
        // Update Source
        //________________________________________

        return response()->json([
            'success' => 'You Update data success'
        ]);
    }

    public function delete( $id ){
        // https://bdev.elmanhag.shop/admin/lesson/delete/{lesson_id}
        $lesson = lesson::where('id', $id)
        ->first();
        $sources = LessonResource::where('lesson_id', $id)
        ->get();

        foreach ($sources as $item) {
            $this->deleteImage($item->file);
        }
        
        $lesson->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
    
}
