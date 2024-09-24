<?php

namespace App\Http\Controllers\api\v1\admin\parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class ParentController extends Controller
{
    public function __construct(private User $user){}

    public function show(){
        $parents = $this->user
        ->where('role', 'parent')
        ->get();

        return response()->json([
            'parents' => $parents
        ]);
    }
}
