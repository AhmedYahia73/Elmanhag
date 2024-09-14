<?php

namespace App\Http\Controllers\api\v1\admin\affilate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AffilateGroupVideos;

class AffVideoGroupController extends Controller
{
    public function __construct(private AffilateGroupVideos $groups){}

    public function show(){
        $groups = $this->groups->get();

        return response()->json([
            'groups' => $groups
        ]);
    }
}
