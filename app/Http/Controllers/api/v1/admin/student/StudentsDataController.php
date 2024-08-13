<?php

namespace App\Http\Controllers\api\v1\admin\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\country;
use App\Models\city;
use App\Models\category;
use App\Models\ParentRelation;
use App\Models\Education;

class StudentsDataController extends Controller
{
    public function show(){
        $students = User::where('role', 'student')
        ->with('subjects')
        ->with('bundles')
        ->with('category')
        ->with('country')
        ->with('city')
        ->get();
        $categories = category::where('category_id', '!=', null)
        ->get();
        $education = Education::get();
        $countries = country::get();
        $cities = city::get();
        $total_students = count($students);
        $banned_students = count($students->where('status', 0));
        $paid_students = User::where('role', 'student')
        ->whereHas('bundles')
        ->orWhere('role', 'student')
        ->whereHas('subjects')
        ->count();
        $free_students = $total_students - $paid_students;
        $relations = ParentRelation::get();

        return response()->json([
            'students' => $students,
            'total_students' => $total_students,
            'banned_students' => $banned_students,
            'paid_students' => $paid_students,
            'free_students' => $free_students,
            'countries' => $countries,
            'cities' => $cities,
            'relations' => $relations,
            'categories' => $categories,
            'education' => $education,
        ]);
    }
}
