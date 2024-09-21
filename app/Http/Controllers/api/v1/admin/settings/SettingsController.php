<?php

namespace App\Http\Controllers\api\v1\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\subject;
use App\Models\bundle;

class SettingsController extends Controller
{
    public function __construct(private subject $subjects, private bundle $bundle){}

    // Determine Semester
    public function semester(Request $request){
        // key
        // semester
        if ($request->semester == 'first') {
            // Active 
            $this->subjects
            ->where('semester', 'first')
            ->update([
                'status' => 1
            ]);
            $this->bundle
            ->where('semester', 'first')
            ->update([
                'status' => 1
            ]);
            // Disable
            $this->subjects
            ->where('semester', 'second')
            ->update([
                'status' => 0
            ]);
            $this->bundle
            ->where('semester', 'second')
            ->update([
                'status' => 0
            ]);
        }
        else{
            // Active 
            $this->subjects
            ->where('semester', 'second')
            ->update([
                'status' => 1
            ]);
            $this->bundle
            ->where('semester', 'second')
            ->update([
                'status' => 1
            ]);
        
            // Disable
            $this->subjects
            ->where('semester', 'first')
            ->update([
                'status' => 0
            ]);
            $this->bundle
            ->where('semester', 'first')
            ->update([
                'status' => 0
            ]);
        }

        return response()->json([
            'success' => 'You active semester success'
        ]);
    }
}
