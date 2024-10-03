<?php

namespace App\Http\Controllers\api\v1\admin\revision;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\subject;
use App\Models\Revision;
use App\Models\category;
use App\Models\question;

class RevisionController extends Controller
{
    public function __construct(private category $category,
    private subject $subjects, private Revision $revision,
    private question $question ){}

    public function show(){
        // https://bdev.elmanhag.shop/admin/revisions
        $subjects = $this->subjects->get();
        $categories = $this->category->get();
        $questions = $this->question->get();
        $revision = $this->revision
        ->with('subject')
        ->with('category')
        ->with('question_groups.questions')
        ->get();

        return response()->json([
            'subjects' => $subjects,
            'revision' => $revision,
            'categories' => $categories,
            'questions' => $questions
        ]);
    }
}
