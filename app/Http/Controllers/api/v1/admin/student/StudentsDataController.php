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
use App\Models\Payment;

class StudentsDataController extends Controller
{
    public function __construct(private User $users, private category $categories,
    private Education $education, private country $countries, private city $cities,
    private ParentRelation $parent_relation, private Payment $payments){}

    public function show(){
        $students = $this->users->where('role', 'student')
        ->with('subjects')
        ->with('bundles')
        ->with('category')
        ->with('country')
        ->with('education')
        ->with('city')
        ->get();
        $categories = $this->categories->where('category_id', '!=', null)
        ->get();
        $education = $this->education->get();
        $countries = $this->countries->get();
        $cities = $this->cities->get();
        $total_students = count($students);
        $banned_students = count($students->where('status', 0));
        $paid_students = $this->users->where('role', 'student')
        ->whereHas('bundles')
        ->orWhere('role', 'student')
        ->whereHas('subjects')
        ->count();
        $free_students = $total_students - $paid_students;
        $relations = $parent_relation->get();

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

    public function purchases(){
        $payments = $this->payments
        ->with(['bundle.category', 'subject.category', 'payment_method'])
        ->where('student_id', auth()->user()->id)
        ->get();
        foreach ($payments as $item) {
            
        }

        return response()->json([
            'payments' => $payments
        ]);
    }
}
