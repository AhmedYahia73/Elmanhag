<?php

namespace App\Http\Controllers\api\v1\admin\question;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\trait\image;

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
    public function create(){
        
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
