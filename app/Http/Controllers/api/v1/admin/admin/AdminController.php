<?php

namespace App\Http\Controllers\api\v1\admin\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\admins\AdminRequest;
use App\Http\Requests\api\admin\admins\UpdateAdminRequest;

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

    public function add(AdminRequest $request){
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
        $this->users
        ->where('id', $id)
        ->where('role', 'admin')
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
