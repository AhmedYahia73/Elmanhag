<?php

namespace App\Http\Controllers\api\v1\admin\homework;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\homework\HomeworkRequest;

use App\Models\homework;
use App\Models\QuestionGroup;

class CreateHomeworkController extends Controller
{
    public function __construct(private homework $homeworks, private QuestionGroup $question_groups){}
    protected $homeworkRequest = [
        'title',
        'semester',
        'category_id',
        'subject_id',
        'chapter_id',
        'lesson_id',
        'difficulty',
        'mark',
        'pass',
        'status',
    ];

    public function create(HomeworkRequest $request){
        // Keys 
        // title, semester, category_id, subject_id, chapter_id, lesson_id, difficulty, mark, pass, status
        // groups[$iteration]
        // questions[$iteration][]
        $homework_data = $request->only($this->homeworkRequest); // Get Data
        $homework = $this->homeworks->create($homework_data); // Create Homework
        foreach ($request->groups as $key => $item) { 
            $group = $this->question_groups->create([
                'name' => $item,
                'homework_id' => $homework->id
            ]);

            foreach ($request->questions[$key] as $element) {
                $group->questions()->attach($element);
            }
        }

        return response()->json([
            'success' => 'You add data success'
        ]);
    }
    
    public function modify(HomeworkRequest $request, $id){
        // Keys 
        // title, semester, category_id, subject_id, chapter_id, lesson_id, difficulty, mark, pass, status
        // groups[$iteration]
        // questions[$iteration][]
        $homework_data = $request->only($this->homeworkRequest);
        $homework = $this->homeworks->where('id', $id)
        ->first()
        ->update($homework_data);
        $this->question_groups->where('homework_id', $id)
        ->delete();
        foreach ($request->groups as $key => $item) { 
            $group = $this->question_groups->create([
                'name' => $item,
                'homework_id' => $id
            ]);

            foreach ($request->questions[$key] as $element) {
                $group->questions()->attach($element);
            }
        }

        return response()->json([
            'success' => 'You Update data success'
        ]);
    }

    public function delete($id){
        $this->homeworks->where('id', $id)
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
