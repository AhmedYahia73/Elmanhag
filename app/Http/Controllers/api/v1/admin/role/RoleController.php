<?php

namespace App\Http\Controllers\api\v1\admin\role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\role\RoleRequest;

use App\Models\AdminPosition;
use App\Models\AdminRole;

class RoleController extends Controller
{
    public function __construct(private AdminPosition $admin_position, private AdminRole $admin_role){}

    public function show(){
        // https://bdev.elmanhag.shop/admin/adminRole
        $admin_position = $this->admin_position
        ->with('roles')
        ->get();
        $roles = ['students', 'teachers', 'admins', 'categories',
        'subjects', 'bundles', 'questions', 'hw', 'revisions', 'exams', 'live',
        'discounts', 'promocode', 'pop up', 'reviews', 'payments',
        'affilate', 'support', 'reports', 'settings', 'notice board', 'chapters',
        'parent', 'lessons',  'admin_roles', 'material'];

        return response()->json([
            'admin_position' => $admin_position,
            'roles' => $roles,
        ]);
    }

    public function add(RoleRequest $request){
        // https://bdev.elmanhag.shop/admin/adminRole/add
        // Keys
        // name
        // roles[]
        $admin_position = $this->admin_position
        ->create(['name' => $request->name]);

        foreach ($request->roles as $item) {
            $this->admin_role
            ->create([
                'role' => $item,
                'admin_position_id' => $admin_position->id
            ]);
        }

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(RoleRequest $request, $id){
        // https://bdev.elmanhag.shop/admin/adminRole/update/1
        // Keys
        // name
        // roles[]
        $admin_position = $this->admin_position
        ->where('id', $id)
        ->update(['name' => $request->name]);
        
        $this->admin_role
        ->where('admin_position_id', $id)
        ->delete();

        foreach ($request->roles as $item) {
            $this->admin_role
            ->create([
                'role' => $item,
                'admin_position_id' => $id
            ]);
        }

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete($id){
        // https://bdev.elmanhag.shop/admin/adminRole/delete/{id}
        $admin_position = $this->admin_position
        ->where('id', $id)
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
