<?php

namespace App\Http\Controllers\api\v1\parent\childreen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class ChildreenController extends Controller
{
    public function __construct(private User $users){}

    public function show(){
        // https://bdev.elmanhag.shop/parent/childreen
        $childreen = auth()->user();
        $childreen = $childreen->childreen;

        return response()->json([
            'childreen' => $childreen
        ]);
    }
}
