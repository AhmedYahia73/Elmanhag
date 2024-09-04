<?php

namespace App\Http\Controllers\api\v1\admin\role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AdminPosition;

class RoleController extends Controller
{
    public function __construct(private AdminPosition $admin_position){}

    public function show(){
        $admin_position = $this->admin_position
        ->with('roles')
        ->get();
        $roles = ['students', 'teachers', 'admins', 'categories',
        'subjects', 'bundles', 'questions', 'hw', 'revisions', 'exams', 'live',
        'discounts', 'promocode', 'pop up', 'reviews', 'pendding payments', 'payments',
        'affilate', 'support', 'reports', 'settings', 'notice board'];

        return response()->json([
            'admin_position' => $admin_position,
            'roles' => $roles,
        ]);
    }
}
