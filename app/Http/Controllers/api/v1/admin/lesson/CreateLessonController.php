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
        $lesson_data = $request->only($this->lessonRequest); // Get data
        $lesson_data['chapter_id'] = $ch_id;
        $this->translate($lesson_data['name'], $lesson_data['name']); // Translate at file json
        $lesson = lesson::create($lesson_data); // Create lesson record
        
        // Add Voice Source
        if ( isset($request->voice) && is_array($request->voice) ) {
            for ($i = 0, $end = count($request->voice); $i < $end; $i++) {
                // Upload voice
                $this->upload($request->voice[$i], 'voice', 'admin/lessons/voice');
                // Create Source
                LessonResource::create([
                    'type' => 'voice', 
                    'source' => $request->source[$i], 
                    'file' => $voice, 
                ]);
            }
        }
        
        // Add Video Source
        if ( isset($request->video) && is_array($request->video) ) {
            for ($i = 0, $end = count($request->video); $i < $end; $i++) {
                // Upload video
                $this->upload($request->video[$i], 'video', 'admin/lessons/video');
                // Create Source
                LessonResource::create([
                    'type' => 'video', 
                    'source' => $request->source[$i], 
                    'file' => $video, 
                ]);
            }
        }
        
        // Add PDF Source
        if ( isset($request->pdf) && is_array($request->pdf) ) {
            for ($i = 0, $end = count($request->pdf); $i < $end; $i++) {
                // Upload pdf
                $this->upload($request->pdf[$i], 'pdf', 'admin/lessons/pdf');
                // Create Source
                LessonResource::create([
                    'type' => 'pdf', 
                    'source' => $request->source[$i], 
                    'file' => $pdf, 
                ]);
            }
        }

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

}
