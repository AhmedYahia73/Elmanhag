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
    ];

    public function create( LessonRequest $request, $ch_id ){
        //Keys 
        // name, ar_name, description, paid, status, order, drip_content
        // voice[], voice_source[]
        // video_source[], video[]
        // pdf_source[], pdf[]
        $lesson_data = $request->only($this->lessonRequest); // Get data
        $lesson_data['chapter_id'] = $ch_id;
        $this->translate($lesson_data['name'], $lesson_data['name']); // Translate at file json
        $lesson = lesson::create($lesson_data); // Create lesson record
        
        // Add Voice Source
        if ( isset($request->voice) && is_array($request->voice) ) {
            // Upload voice
            $voice_paths = $this->upload_array_of_file($request, 'voice', 'admin/lessons/voice');
            if ( !empty($voice_paths) && $voice_paths != null ) {
                for ($i = 0, $end = count($request->voice); $i < $end; $i++) {
                    // Create Source
                    LessonResource::create([
                        'type' => 'voice', 
                        'source' => $request->voice_source[$i], 
                        'file' => $voice_paths[$i], 
                    ]);
                }
            }
        }
        
        // Add Video Source
        if ( isset($request->video) && is_array($request->video) ) {
            // Upload video
            $video_paths = $this->upload_array_of_file($request, 'video', 'admin/lessons/video');
            if ( !empty($video_paths) && $video_paths != null ) {
                for ($i = 0, $end = count($request->video); $i < $end; $i++) {
                    // Create Source
                    LessonResource::create([
                        'type' => 'video', 
                        'source' => $request->video_source[$i], 
                        'file' => $video_paths[$i], 
                    ]);
                }
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
                        'source' => $request->pdf_source[$i], 
                        'file' => $pdf_paths[$i],
                    ]);
                }
            }
        }

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

}
