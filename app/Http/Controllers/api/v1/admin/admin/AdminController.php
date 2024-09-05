<?php

namespace App\Http\Controllers\api\v1\admin\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class AdminController extends Controller
{
    public function __construct(private User $users){}

    public function show(){
        $admins = $this->users
        ->where('role', 'admin')
        ->with('admin_position')
        ->get();

        return response()->json([
            'admins' => $admins
        ]);
    }
}
