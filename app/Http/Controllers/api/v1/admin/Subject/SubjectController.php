<?php

namespace App\Http\Controllers\api\v1\admin\Subject;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\subject;
use App\Models\category;
use App\Models\Education;

class SubjectController extends Controller
{
    public function __construct(private subject $subject, 
    private category $category, private Education $education ){}

    public function show(){
        // https://bdev.elmanhag.shop/admin/subject
        // Get data
        $subjects = $this->subject
        ->with([
            'discount',
            'category',
            'chapters.lessons.resources',
            'users',
            'bundles.users',
        ])
        ->withCount([
            'chapters'
        ])
        ->get();

        // Add students from bundels and subjects at users
        foreach ($subjects as $item) {
            $arr = $item->users;
            foreach ($item->bundles as $element) {
                $arr = $arr->merge($element->users);
            }
            $item->students = $arr;
            $item->students_count = count($arr);
        }
        // Education
        $education = $this->education->get();
        // Category
        $categories = $this->category
        ->where('category_id', '!=', null)
        ->orderBy('category_id')
        ->get();

        foreach ($subjects as $subject) {
            $lessons = 0;
            // Manually add the count of lessons to each chapter
            foreach ($subject->chapters as $chapter) {
                $lessons += $chapter->lessons()->count();
            }
            // Manually add price after discount
            foreach ($subject->discount as $discount) {
                if ( $discount->type == 'precentage' ) {
                    $subject->price_discount = $subject->price - ($subject->price * $discount->amount / 100);
                } else {
                    $subject->price_discount = $subject->price - $discount->amount;
                }
                break;
            }
            $subject->lesson_count = $lessons;
        }

        return response()->json([
            'subjects' => $subjects,
            'categories' => $categories,
            'education' => $education,
        ]);

    }

    public function subject_progress($id){
        // Get data
        $subject = $this->subject
        ->where('id', $id)
        ->with([
            'users.user_homework',
            'bundles.users.user_homework',
            'chapters.lessons',
        ])
        ->first();

        // Get Students that buy this subject
        $arr = $subject->users;
        foreach ($subject->bundles as $element) {
            $arr = $arr->merge($element->users);
        }
        $subject->students = $arr;

        // Get chapters of subject
        $lessons = [];
        foreach ($subject->chapters as $item) {
            $lessons = array_merge($item->lessons->pluck('id')->toArray(), $lessons);
        }

        foreach ($subject->students as $item) {
            // Get H.W. that student pass at it and determine one score to every hw
            $hw = [];
            foreach ($item->user_homework as $element) {
                if ($element->pass <= $element->pivot->score && in_array($element->pivot->lesson_id ,$lessons)) {
                    $hw[$element->id] = $element;
                }
            }

            $progress = 0;
            // Calculate progress of student to subject
            foreach ($hw as $element) {
                if ($element->title == 'H.W1') {
                    $progress += 50;
                }
                elseif ($element->title == 'H.W2') {
                    $progress += 35;
                }
                elseif ($element->title == 'H.W3') {
                    $progress += 15;
                }
            }
            if (count($lessons) != 0) {
                $progress /= count($lessons);
            }
            $item->progress = $progress;
        }

        return response()->json([
            'students' => $subject->students
        ]);
    }
}
