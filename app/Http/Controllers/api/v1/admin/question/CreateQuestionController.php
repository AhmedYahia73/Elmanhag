<?php

namespace App\Http\Controllers\api\v1\admin\question;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\trait\image;
use App\Http\Requests\api\admin\question\QuestionRequest;

use App\Models\question;
use App\Models\question_answer;

class CreateQuestionController extends Controller
{
    public function __construct(private question $question, 
    private question_answer $question_answer){}
    use image;
    protected $questionRequest = [
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
        // https://bdev.elmanhag.shop/admin/question/add 
        // keys => question, image, audio, status, category_id, subject_id, 
        // chapter_id, lesson_id, semester['first', 'second'], difficulty,
        // answer_type ['Mcq', 'T/F', 'Join', 'Complete', 'Reorder', 'Essay'], question_type ['text', 'image', 'audio']
        // answer, true_answer
        $question_data = $request->only($this->questionRequest); // Get request
        if ( $question_data['question_type'] == 'image' ) { // if request send image
            $image_path = $this->upload($request, 'image', 'admin/questions/image'); // Upload image
            $question_data['image'] = $image_path;
        }
        elseif ( $question_data['question_type'] == 'audio' ) { // if request send audio
            $audio_path = $this->upload($request, 'audio', 'admin/questions/audio'); // Upload audio
            $question_data['audio'] = $audio_path;
        }

        if ($question_data['answer_type'] != 'Complete' && $question_data['answer_type'] != 'Reorder'
        && $question_data['answer_type'] != 'Essay') {
            $question_data['question'] = $request->question;
            $question = $this->question->create($question_data); // Create Question
            $this->question_answer->create([
                'answer' => json_encode($request->answer),
                'true_answer' => $request->true_answer,
                'question_id' => $question->id
            ]); // Create Answer
        }
        elseif ($question_data['answer_type'] == 'Reorder') {
            $question_data['question'] = $request->question;
            $question = $this->question->create($question_data); // Create Question
            $this->question_answer->create([
                'answer' => json_encode($request->answer),
                'true_answer' => json_encode($request->answer),
                'question_id' => $question->id
            ]); // Create Answer
        }
        elseif ($question_data['answer_type'] == 'Complete') {
            $question_data['question'] = json_encode($request->question);
            $question = $this->question->create($question_data); // Create Question
            $this->question_answer->create([
                'answer' => json_encode($request->answer),
                'true_answer' => json_encode($request->answer),
                'question_id' => $question->id
            ]); // Create Answer
        }
        elseif ($question_data['answer_type'] == 'Essay') {
            $question_data['question'] = json_encode($request->question);
            $question = $this->question->create($question_data); // Create Question
            $this->question_answer->create([
                'answer' => json_encode([]),
                'true_answer' => json_encode($request->answer),
                'question_id' => $question->id
            ]); // Create Answer
        }

        return response()->json([
            'success' => 'You add data success'
        ]);
    }
    
    public function modify(QuestionRequest $request, $id){
        // https://bdev.elmanhag.shop/admin/question/update/{id}
        // keys => question, image, audio, status, category_id, subject_id, chapter_id, 
        // lesson_id, semester['first', 'second'], difficulty, answer_type ['Mcq', 'Reorder', 'T/F', 'Join', 'Complete', 'Essay'], 
        // question_type ['text', 'image', 'audio']
        // answer, true_answer
        $question_data = $request->only($this->questionRequest); // Get request
        $question = $this->question->where('id', $id)
        ->first(); //Get Question
        if ( $question_data['question_type'] == 'image' ) { // if request send image
            if (is_file($request->image)) {
                $image_path = $this->upload($request, 'image', 'admin/questions/image'); // Upload image
                if ( !empty($image_path) && $image_path != null ) { // if he upload new image
                    $question_data['image'] = $image_path;
                    $question_data['audio'] = null;
                    $this->deleteImage($question->image); // Delete old image
                    $this->deleteImage($question->audio); // Delete old audio
                }
            }
        }
        elseif ( $question_data['question_type'] == 'audio' ) { // if request send audio
            if (is_file($request->audio)) {
                $audio_path = $this->upload($request, 'audio', 'admin/questions/audio'); // Upload audio
                if ( !empty($audio_path) && $audio_path != null ) { // if he upload new audio
                    $question_data['audio'] = $audio_path;
                    $question_data['image'] = null;
                    $this->deleteImage($question->image);
                    $this->deleteImage($question->audio);
                }
            }
        }
        elseif ( $question_data['question_type'] == 'text' ) {
            $question_data['audio'] = null;
            $question_data['image'] = null;
            $this->deleteImage($question->image);
            $this->deleteImage($question->audio);
        }
        
        $this->question_answer
        ->where('question_id', $id)->delete();
        if ($question_data['answer_type'] != 'Complete' && $question_data['answer_type'] != 'Reorder'
        && $question_data['answer_type'] != 'Essay') {
            $question_data['question'] = $request->question;
            $question->update($question_data);
            $this->question_answer->create([
                'answer' => json_encode($request->answer),
                'true_answer' => $request->true_answer,
                'question_id' => $id
            ]); // Create Answer
        }
        elseif ($question_data['answer_type'] == 'Reorder') {
            $question_data['question'] = $request->question;
            
            $question->update($question_data);
            $this->question_answer->create([
                'answer' => json_encode($request->answer),
                'true_answer' => json_encode($request->answer),
                'question_id' => $id
            ]); // Create Answer
        }
        elseif ($question_data['answer_type'] == 'Complete') {
            $question_data['question'] = json_encode($request->question);
            
            $question->update($question_data);
            $this->question_answer->create([
                'answer' => json_encode($request->answer),
                'true_answer' => json_encode($request->answer),
                'question_id' => $id
            ]); // Create Answer
        }
        elseif ($question_data['answer_type'] == 'Essay') {
            $question_data['question'] = json_encode($request->question);
            $question = $this->question->create($question_data); // Create Question
            $this->question_answer->create([
                'answer' => json_encode([]),
                'true_answer' => json_encode($request->answer),
                'question_id' => $question->id
            ]); // Create Answer
        } 

        return response()->json([
            'success' => 'You update data success'
        ]);
    }
    
    public function delete( $id ){
        // https://bdev.elmanhag.shop/admin/question/delete/{id}
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
