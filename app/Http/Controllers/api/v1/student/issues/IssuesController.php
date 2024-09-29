<?php

namespace App\Http\Controllers\api\v1\student\issues;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

use App\Models\QuestionIssues;
use App\Models\VideoIssues;
use App\Models\StudentQuestionIssue;
use App\Models\StudentVideoIssue;

class IssuesController extends Controller
{
    public function __construct(private QuestionIssues $question_issues, 
    private VideoIssues $video_issues, private StudentQuestionIssue $student_question_issue,
    private StudentVideoIssue $student_video_issue){}

    public function view(){
        $question_issues = $this->question_issues
        ->get();
        $video_issues = $this->video_issues
        ->get();

        return response()->json([
            'question_issues' => $question_issues,
            'video_issues' => $video_issues,
        ]);
    }

    public function add(Request $request){
        // Keys
        // type, issue_id, id
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:question,video',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }

        if ($request->type == 'question') {
            $validator = Validator::make($request->all(), [
                'issue_id' => 'required|exists:question_issues,id',
                'id' => 'required|exists:questions,id',
            ]);
            if ($validator->fails()) { // if Validate Make Error Return Message Error
                return response()->json([
                    'error' => $validator->errors(),
                ],400);
            }

            $this->student_question_issue
            ->create([
                'question_id' => $request->id ,
                'user_id' => auth()->user()->id ,
                'question_issue_id' => $request->issue_id ,
            ]);
        }
        elseif ($request->type == 'video') {
            $validator = Validator::make($request->all(), [
                'issue_id' => 'required|exists:video_issues,id',
                'id' => 'required|exists:lesson_resources,id',
            ]);
            if ($validator->fails()) { // if Validate Make Error Return Message Error
                return response()->json([
                    'error' => $validator->errors(),
                ],400);
            }

            $this->student_video_issue
            ->create([
                'lesson_resource_id' => $request->id ,
                'user_id' => auth()->user()->id ,
                'video_issue_id' => $request->issue_id ,
            ]);
        }

        return response()->json([
            'success' => 'You record issue success'
        ]);
    }
}
