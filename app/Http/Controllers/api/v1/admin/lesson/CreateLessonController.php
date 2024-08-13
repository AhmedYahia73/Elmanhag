<?php

namespace App\Http\Controllers\api\v1\admin\lesson;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\trait\image;
use App\trait\translaion;
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
        'order',
        'drip_content',
        'chapter_id',
    ];

    public function create( LessonRequest $request, $ch_id ){
        //Keys 
        // name, ar_name, description, paid, status, order, drip_content
        // voice[], voice_link[]
        // voice_source[] لما يكون link فقط
        // video[], video_link[]
        // video_source[]  لما يكون link فقط
        // pdf[], pdf_link[]
        // pdf_source[] لما يكون link فقط
        $lesson_data = $request->only($this->lessonRequest); // Get data
        $lesson_data['chapter_id'] = $ch_id;
        $this->translate($lesson_data['name'], $lesson_data['name']); // Translate at file json
        $lesson = lesson::create($lesson_data); // Create lesson record
        
        // Add Voice Source
        if ( isset($request->voice) && is_array($request->voice) ) {
            // Upload voice
            $voice_paths = $this->upload_array_of_file($request, 'voice', 'admin/lessons/voice');
            for ($i = 0, $end = count($request->voice); $i < $end; $i++) {
                // if source file
                LessonResource::create([
                    'type' => 'voice', 
                    'source' => 'upload', 
                    'file' => $voice_paths[$i], 
                    'lesson_id' => $lesson->id,
                ]);
            }
        }

        // if source voice and link
        if ( isset($request->voice_link) ) {
            for ($i=0, $end = count($request->voice_link); $i < $end; $i++) { 
                // Create Source
                LessonResource::create([
                    'type' => 'voice', 
                    'source' => $request->voice_source[$i], 
                    'link' => $request->voice_link[$i], 
                    'lesson_id' => $lesson->id,
                ]);
            }
        }
        
        // Add Video Source
        if ( isset($request->video) && is_array($request->video) ) {
            // Upload video
            $video_paths = $this->upload_array_of_file($request, 'video', 'admin/lessons/video');
            if ( !empty($video_paths) && $video_paths != null ) {
                for ($i = 0, $end = count($request->video); $i < $end; $i++) {  
                    // if source file 
                    // Create Source
                    LessonResource::create([
                        'type' => 'video', 
                        'source' => 'upload', 
                        'file' => $video_paths[$i],
                        'lesson_id' => $lesson->id,
                    ]);
                }
            }
        }

        // if source video and link
        if ( isset($request->video_link) ) {
            for ($i=0, $end = count($request->video_link); $i < $end; $i++) { 
                // Create Source
                LessonResource::create([
                    'type' => 'video', 
                    'source' => $request->video_source[$i], 
                    'link' => $request->video_link[$i], 
                    'lesson_id' => $lesson->id,
                ]);
            }
        }
        
        // Add PDF Source
        if ( isset($request->pdf) && is_array($request->pdf) ) {
            // Upload pdf
            $pdf_paths = $this->upload_array_of_file($request, 'pdf', 'admin/lessons/pdf');
            if ( !empty($pdf_paths) && $pdf_paths != null ) {
                for ($i = 0, $end = count($request->pdf); $i < $end; $i++) {
                    // Create Source
                    LessonResource::create([
                        'type' => 'pdf', 
                        'source' => 'upload', 
                        'file' => $pdf_paths[$i],
                        'lesson_id' => $lesson->id,
                    ]);
                }
            }
        }

        // if source pdf and link
        if ( isset($request->pdf_link) ) {
            for ($i=0, $end = count($request->pdf_link); $i < $end; $i++) { 
                // Create Source
                LessonResource::create([
                    'type' => 'pdf', 
                    'source' => $request->pdf_source[$i], 
                    'link' => $request->pdf_link[$i], 
                    'lesson_id' => $lesson->id,
                ]);
            }
        }
    

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify( LessonRequest $request, $id ){
        //Keys 
        // name, ar_name, description, paid, status, order, drip_content
        // voice[], voice_source[]
        // video_source[], video[]
        // pdf_source[], pdf[]
        $lesson_data = $request->only($this->lessonRequest); // Get data
        $lesson = lesson::where('id', $id)
        ->first();
        $this->translate($lesson_data['name'], $lesson_data['name']); // Translate at file json
        $lesson->update($lesson_data);
        
        // Update Source
        //________________________________________

        return response()->json([
            'success' => 'You Update data success'
        ]);
    }

    public function delete( $id ){
        $lesson = lesson::where('id', $id)
        ->first();
        $sources = LessonResource::where('lesson_id', $id)
        ->get();

        foreach ($sources as $item) {
            $this->deleteImage($item->file);
        }

        $sources->delete();
        $lesson->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
    
}
