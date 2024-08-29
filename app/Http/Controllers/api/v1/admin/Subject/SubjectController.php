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
        // Get data
        $subjects = $this->subject
        ->with([
            'discount',
            'category',
            'chapters.lessons.materials',
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

    public function subject_progress(){

    }
}
