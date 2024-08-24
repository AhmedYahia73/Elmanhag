<?php

namespace App\Http\Controllers\api\v1\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Setting;

class SettingsController extends Controller
{
    public function __construct(private Setting $settings){}

    // Determine Semester
    public function semester(Request $request){
        // key
        // semester
        $semester = $this->settings
        ->where('name', 'semester')
        ->first(); // Get setting of semester

        if ( empty($semester) ) {
            $semester->create([
                'name' => 'semester',
                'setting' => $request->semester,
            ]); // if semester settings is not found insert new semester
        }
        else{
            $semester->update([
                'setting' => $request->semester,
            ]);
        } // if semester settings is found update semester

        return response()->json([
            'success' => 'You active semester success'
        ]);
    }
}
