<?php

namespace App\Http\Controllers\api\v1\student\revision;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Revision;

class RevisionController extends Controller
{
    public function __construct(private Revision $revisions){}

    public function revisions(){
        // https://bdev.elmanhag.shop/student/revision
        $user_id = auth()->user()->id;
        $revisions = $this->revisions
        ->whereHas('user', function($query) use($user_id){
            $query->where('users.id', $user_id);
        })
        ->with(['videos'])
        ->get();

        return response()->json([
            'revisions' => $revisions
        ]);
    }
}
