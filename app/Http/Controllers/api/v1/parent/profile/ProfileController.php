<?php

namespace App\Http\Controllers\api\v1\parent\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class ProfileController extends Controller
{
    public function __construct(private User $user){}
    protected $parentRequest = [
        'name',
    ];

    public function modify(Request $request){
        // https://bdev.elmanhag.shop/parent/profile
        // Keys
        // name, password
        $parentData = $request->only($this->parentRequest);
        if (isset($request->password) && !empty($request->password)) {
            $parentData['password'] = Hash::make($request->password);
        }
        $this->user->where('id', auth()->user()->id)
        ->update($parentData);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }
}
