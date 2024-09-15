<?php

namespace App\Http\Controllers\api\v1\admin\complaint;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Complaint;

class ComplaintController extends Controller
{
    public function __construct(private Complaint $complaints){}

    public function pendding(){
        // https://bdev.elmanhag.shop/admin/complaint
        $complaints = $this->complaints
        ->where('status', 0)
        ->with('student')
        ->get();

        return response()->json([
            'complaints' => $complaints
        ]);
    }

    public function history(){
        // https://bdev.elmanhag.shop/admin/complaint/history
        $complaints = $this->complaints
        ->where('status', 1)
        ->with('student')
        ->get();

        return response()->json([
            'complaints' => $complaints
        ]);
    }

    public function active($id){
        // https://bdev.elmanhag.shop/admin/complaint/active/{id}
        $this->complaints
        ->where('id', $id)
        ->update(['status' => 1]);

        return response()->json([
            'success' => 'You active message success'
        ]);
    }
}
