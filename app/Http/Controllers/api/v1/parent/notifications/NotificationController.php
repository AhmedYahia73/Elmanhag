<?php

namespace App\Http\Controllers\api\v1\parent\notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\homework;

class NotificationController extends Controller
{
    public function __construct(private User $users, private homework $homeworks){}
    
    public function show(){

    }
}
