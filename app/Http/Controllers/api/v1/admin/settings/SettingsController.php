<?php

namespace App\Http\Controllers\api\v1\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Setting;

class SettingsController extends Controller
{
    public function __construct(private Setting $settings){}

    // Determine Semester
    public function semester(Request $req){

    }
}
