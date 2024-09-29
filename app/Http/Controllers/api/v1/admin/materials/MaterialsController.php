<?php

namespace App\Http\Controllers\api\v1\admin\materials;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\category;
use App\Models\subject;
use App\Models\chapter;
use App\Models\lesson;
use App\Models\MaterialLesson;

class MaterialsController extends Controller
{
    public function __construct(private category $category, private subject $subject,
    private chapter $chapter, private lesson $lesson, private MaterialLesson $materials){}

    public function view(){
        // https://bdev.elmanhag.shop/admin/materials
        $category = $this->category
        ->get();
        $subject = $this->subject
        ->get();
        $chapter = $this->chapter
        ->get();
        $lesson = $this->lesson
        ->get();
        $materials = $this->materials
        ->get();

        return response()->json([
            'categories' => $category,
            'subjects' => $subject,
            'chapters' => $chapter,
            'lessons' => $lesson,
            'materials' => $materials,
        ]);
    }
}
