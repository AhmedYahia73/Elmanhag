<?php

namespace App\Http\Controllers\api\v1\admin\question;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\trait\image;
use App\Http\Requests\api\admin\question\QuestionRequest;

use App\Models\question;

class CreateQuestionController extends Controller
{
    use image;
    protected $questionRequest = [
        'question',
        'status',
        'category_id',
        'subject_id',
        'chapter_id',
        'lesson_id',
        'semester',
        'difficulty',
        'answer_type',
        'question_type',
    ];
    public function create(QuestionRequest $request){
        $question_data = $request->only($this->questionRequest);
        if ( $question_data['question_type'] == 'image' ) {
            $image_path = $this->upload($request, 'image', 'admin/questions/image');
            $question_data['image'] = $image_path;
        }
        elseif ( $question_data['question_type'] == 'audio' ) {
            $audio_path = $this->upload($request, 'audio', 'admin/questions/audio');
            $question_data['audio'] = $audio_path;
        }
        question::create($question_data);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }
    
    public function modify(){
        
    }
    
    public function delete( $id ){
        $question = question::where('id', $id)
        ->first();
        $this->deleteImage($question->image);
        $this->deleteImage($question->audio);
        $question->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
