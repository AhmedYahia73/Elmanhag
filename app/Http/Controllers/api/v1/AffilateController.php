<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class AffilateController extends Controller
{
    public function __construct(private User $user){}

    public function create_affilate(Request $request){
        $validator = Validator::make($request->all(), [
        'user_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                    'error' => $validator->errors(),
            ],400);
        }

        $user = $this->user
        ->where('id', $request->user_id)
        ->first();   
        $affilate_code = rand(100000, 999999);
        $db_affilate_code = $this->user->where('affilate_code', $affilate_code)
        ->first(); // get affilate that have the same code to check if code frequent
        while (!empty($db_affilate_code)) { // if code is exist it will changed
            $affilate_code = rand(100000, 999999);
            $db_affilate_code = $this->user->where('affilate_code', $affilate_code)
            ->first(); // get affilate that have the same code to check if code frequent
        }
        $user->update([
            'affilate_code' => $affilate_code
        ]);

        return response()->json([
            'affilate_code' => $affilate_code
        ]);
    }
}
