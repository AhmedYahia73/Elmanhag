<?php

namespace App\Http\Controllers\api\v1\admin\homework;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\homework\HomeworkRequest;
use App\trait\image;

use App\Models\homework;
use App\Models\QuestionGroup;

class CreateHomeworkController extends Controller
{
    use image;
    public function __construct(private homework $homeworks, private QuestionGroup $question_groups){}
    protected $homeworkRequest = [
        'title',
        'semester',
        'due_date',
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
        // https://bdev.elmanhag.shop/admin/homework/add
        // Keys 
        // title, semester, due_date, category_id, subject_id, chapter_id, lesson_id, difficulty, 
        // mark, pass, status, homework
        // groups[$iteration]
        // questions[$iteration][]
        $homework_data = $request->only($this->homeworkRequest); // Get Data
        if (is_file($request->homework)) { 
            $homework_path =  $this->upload($request,'homework','admin/homework'); // Upload homework
            $homework_data['homework'] = $homework_path;
        }
        $homework = $this->homeworks->create($homework_data); // Create Homework
        if ($request->groups) {
            foreach ($request->groups as $key => $item) { 
                $group = $this->question_groups->create([
                    'name' => $item,
                    'homework_id' => $homework->id
                ]);
    
                foreach ($request->questions[$key] as $element) {
                    $group->questions()->attach($element);
                }
            }
        }

        return response()->json([
            'success' => 'You add data success'
        ]);
    }
    
    public function modify(HomeworkRequest $request, $id){
        // https://bdev.elmanhag.shop/admin/homework/update/{id}
        // Keys 
        // title, semester, due_date, category_id, subject_id, chapter_id, 
        // homework, lesson_id, difficulty, mark, pass, status
        // groups[$iteration]
        // questions[$iteration][]
        $homework_data = $request->only($this->homeworkRequest);
        $homework = $this->homeworks->where('id', $id)
        ->first();
        if (is_file($request->homework)) { 
            $this->deleteImage($homework->homework); // Delete old homework
            $homework_path =  $this->upload($request,'homework','admin/homework'); // Upload homework
            $homework_data['homework'] = $homework_path;
        }
        $homework->update($homework_data);
        $this->question_groups->where('homework_id', $id)
        ->delete();
        if ($request->groups) {
            foreach ($request->groups as $key => $item) { 
                $group = $this->question_groups->create([
                    'name' => $item,
                    'homework_id' => $id
                ]);
    
                foreach ($request->questions[$key] as $element) {
                    $group->questions()->attach($element);
                }
            }
        }

        return response()->json([
            'success' => 'You Update data success'
        ]);
    }

    public function delete($id){
        // https://bdev.elmanhag.shop/admin/homework/delete/{id}
        $this->homeworks->where('id', $id)
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
