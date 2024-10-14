<?php

namespace App\Http\Controllers\api\v1\admin\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\admins\AdminRequest;
use App\Http\Requests\api\admin\admins\UpdateAdminRequest;
use Illuminate\Contracts\Validation\Validator;

use App\Models\User;
use App\Models\AdminPosition;

class AdminController extends Controller
{
    public function __construct(private User $users, private AdminPosition $admin_position){}
    protected $adminRequest = [
        'name',
        'phone',
        'email',
        'status',
        'password',
        'admin_position_id',
    ];

    public function show(){
        // https://bdev.elmanhag.shop/admin/admins
        $admins = $this->users
        ->where('role', 'admin')
        ->with('admin_position')
        ->get();
        $admin_position = $this->admin_position
        ->get();

        return response()->json([
            'admins' => $admins,
            'roles' => $admin_position
        ]);
    }

    public function status(Request $request, $id){
        // https://bdev.elmanhag.shop/admin/admins/status/{id}
        // Keys
        // status
        $validator = Validator::make($request->all(), [
            'status' => 'required|boolean',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }

        $this->user->where('id', $id)
        ->where('role', 'admin')
        ->update([
            'status' => $request->status
        ]);

        if ($request->status == 0) {
            return response()->json([
                'success' => 'banned'
            ]);
        } else {
            return response()->json([
                'success' => 'active'
            ]);
        }
        
    }

    public function admin($id){
        // https://bdev.elmanhag.shop/admin/admins/admin/{id}
        $admins = $this->users
        ->where('role', 'admin')
        ->where('id', $id)
        ->with('admin_position')
        ->first();

        return response()->json([
            'admins' => $admins,
        ]);
    }

    public function add(AdminRequest $request){
        // https://bdev.elmanhag.shop/admin/admins/add
        // Keys
        // name, phone, email, status, password, admin_position_id
        $admin_data = $request->only($this->adminRequest);
        $admin_data['role'] = 'admin';
        $this->users
        ->create($admin_data);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(UpdateAdminRequest $request, $id){
        // https://bdev.elmanhag.shop/admin/admins/update/{id}
        // Keys
        // name, phone, email, status, password, admin_position_id
        $admin_data = $request->only($this->adminRequest);
        $this->users
        ->where('id', $id)
        ->where('role', 'admin')
        ->update($admin_data);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete($id){
        // https://bdev.elmanhag.shop/admin/admins/delete/{id}
        $this->users
        ->where('id', $id)
        ->where('role', 'admin')
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
