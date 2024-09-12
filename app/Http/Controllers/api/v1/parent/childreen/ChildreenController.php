<?php

namespace App\Http\Controllers\api\v1\parent\childreen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\parent\childreen\ChildProfileRequest;

use App\Models\User;

class ChildreenController extends Controller
{
    public function __construct(private User $users){}
    protected $childRequest = [
        'name',
        'category_id',
        'education_id',
        'country_id',
        'city_id',
        'phone',
    ];

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

    public function child_profile($id, ChildProfileRequest $request){
        $childData = $request->only($this->childRequest);
        $this->users
        ->where('id', $id)
        ->where('parent_id', auth()->user()->id)
        ->update($childData);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }
}
