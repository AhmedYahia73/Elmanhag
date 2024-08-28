<?php

namespace App\Http\Controllers\api\v1\admin\Subject;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\subject;
use App\Models\category;
use App\Models\Education;

class SubjectController extends Controller
{
    public function show(){
        // Get data
        $subjects = Subject::with([
            'discount',
            'category',
            'chapters.lessons.materials',
            'users',
        ])
        ->withCount([
            'users as students',
            'chapters'
        ])
        ->get();
        // Education
        $education = Education::get();
        // Category
        $categories = category::
        where('category_id', '!=', null)
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
}
