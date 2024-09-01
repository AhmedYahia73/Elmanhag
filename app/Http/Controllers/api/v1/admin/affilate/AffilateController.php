<?php

namespace App\Http\Controllers\api\v1\admin\affilate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class AffilateController extends Controller
{
    public function __construct(private User $user){}

    public function affilate(){
        $total_affilate = $this->user
        ->where('role', 'affilate')
        ->get();
    }
}
