<?php

namespace App\Http\Controllers\api\v1\admin\revision;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\subject;
use App\Models\Revision;
use App\Models\category;

class RevisionController extends Controller
{
    public function __construct(private category $category,
    private subject $subjects, private Revision $revision){}

    public function show(){
        // https://bdev.elmanhag.shop/admin/revisions
        $subjects = $this->subjects->get();
        $categories = $this->category->get();
        $revision = $this->revision
        ->with(['subject', 'category', 'videos']) 
        ->get();

        return response()->json([
            'subjects' => $subjects,
            'revision' => $revision,
            'categories' => $categories,
        ]);
    }
}
