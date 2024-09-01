<?php

namespace App\Http\Controllers\api\v1\admin\chapter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\chapter;

class ChapterController extends Controller
{
    public function __construct(private chapter $chapter){}
    public function show($subject_id){
        $chapters = $this->chapter
        ->with('subject')
        ->with('lessons')
        ->where('subject_id', $subject_id)
        ->get();

        return response()->json([
            'chapters' => $chapters
        ]);
    }
}
