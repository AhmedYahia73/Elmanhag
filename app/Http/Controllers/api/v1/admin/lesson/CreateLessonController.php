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
        'chapter_id',
        'status',
        'order',
        'drip_content',
    ];

    public function create( LessonRequest $request ){
        $lesson_data = $request->only($this->lessonRequest); // Get data
        $this->translate($lesson_data['name'], $lesson_data['name']); // Translate at file json
        $lesson = lesson::create($lesson_data); // Create lesson record
        
        // Add Voice Source
        if ( isset($request->voice) && is_array($request->voice) ) {
            for ($i = 0, $end = count($request->voice); $i < $end; $i++) {
                $voice = $this->upload($request);
                LessonResource::create([
                    'type' => 'voice', 
                    'source' => $request->source[$i], 
                    'file' => $voice, 
                ]);
            }
        }
    }

}
