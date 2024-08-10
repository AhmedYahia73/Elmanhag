<?php

namespace App\Http\Controllers\api\v1\admin\chapter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\chapter;

class ChapterController extends Controller
{
    public function show(){
        $chapters = chapter::
        with('subject')
        ->orderBy('subject_id')
        ->get();

        return response()->json([
            'chapters' => $chapters
        ]);
    }
}
