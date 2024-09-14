<?php

namespace App\Http\Controllers\api\v1\admin\affilate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

use App\Models\AffilateGroupVideos;

class AffVideoGroupController extends Controller
{
    public function __construct(private AffilateGroupVideos $groups){}

    public function show(){
        // https://bdev.elmanhag.shop/admin/affilate/groups
        $groups = $this->groups->get();

        return response()->json([
            'groups' => $groups
        ]);
    }

    public function add(Request $request){      
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
        $this->groups->create([
            'name' => $request->name
        ]);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }
}
