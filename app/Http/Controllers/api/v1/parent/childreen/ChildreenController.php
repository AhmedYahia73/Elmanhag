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
        $childreen = $this->users
        ->where('id', auth()->user()->id)
        ->with('childreen', function($query){
            $query->with(['category', 'education', 'country', 'city']);
        })
        ->first();
        $childreen = $childreen->childreen;

        return response()->json([
            'childreen' => $childreen
        ]);
    }
}
