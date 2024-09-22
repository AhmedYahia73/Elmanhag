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
use App\Models\bundle;
use App\Models\subject;
use App\Models\Live;
use App\Models\PaymentMethod;

class StudentsDataController extends Controller
{
    public function __construct(private User $users, private category $categories,
    private Education $education, private country $countries, private city $cities,
    private ParentRelation $parent_relation, private Payment $payments, private bundle $bundles,
    private subject $subjects, private Live $live, private PaymentMethod $payment_method
    ){}

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

    public function purchases(Request $request){
        $payments = $this->payments
        ->with(['bundle.category', 'subject.category', 'live.category', 'payment_method'])
        ->where('student_id', $request->student_id)
        ->get();
        foreach ($payments as $item) {
            $price = 0;
            foreach ($item->bundle as $element) {
                $price += $element->price;
            }
            foreach ($item->subject as $element) {
                $price += $element->price;
            }
            foreach ($item->live as $element) {
                $price += $element->price;
            }
            $item->price = $price;
            $item->discount = $price - $item->amount;
        }

        return response()->json([
            'purchases' => $payments
        ]);
    }

    public function purchases_data(Request $request){
        $student = $this->users
        ->where('id', $request->student_id)
        ->first();
        $bundles = $this->bundles
        ->where('category_id', $student->category_id)
        ->where('education_id', $student->education_id)
        ->whereDoesntHave('users', function ($query) use($student) {
            $query->where('users.id', $student->id);
        })
        ->orWhereNull('education_id')
        ->where('category_id', $student->category_id)
        ->whereDoesntHave('users', function ($query) use($student) {
            $query->where('users.id', $student->id);
        })
        ->with('discount')
        ->get(); // Get bundles that havs the same category of student and student does not buy it
        $student_bundles = $this->bundles
        ->where('category_id', $student->category_id)
        ->where('education_id', $student->education_id)
        ->whereHas('users', function ($query) use($student){
            $query->where('users.id', $student->id);
        })
        ->orWhereNull('education_id')
        ->where('category_id', $student->category_id)
        ->whereHas('users', function ($query) use($student){
            $query->where('users.id', $student->id);
        })
        ->with('subjects')
        ->get(); // Get bundles that student buy it with its subjects
        $bundles_subjects = [];
        foreach ($student_bundles as $item) {
            $bundles_subjects = array_merge($bundles_subjects, 
            $item->subjects->pluck('id')->toArray());
        } 
        $subjects = $this->subjects
        ->where('category_id', $student->category_id)
        ->where('education_id', $student->education_id)
        ->whereDoesntHave('users', function ($query) use($student) {
            $query->where('users.id', $student->id);
        })
        ->whereNotIn('id', $bundles_subjects)
        ->orWhereNull('education_id')
        ->where('category_id', $student->category_id)
        ->whereDoesntHave('users', function ($query) use($student) {
            $query->where('users.id', $student->id);
        })
        ->whereNotIn('id', $bundles_subjects)
        ->with('discount')
        ->get(); // Get subject that havs the same category of student and student does not buy it

        foreach ($subjects as $subject) {
            $lessons = 0;
            // Manually add the count of lessons to each chapter
            foreach ($subject->chapters as $chapter) {
                $lessons += $chapter->lessons()->count();
            }
            // Manually add price after discount
            foreach ($subject->discount as $discount) {
                if ( $discount->type == 'precentage' ) {
                    $subject->price_discount = $subject->price - ($subject->price * $discount->amount / 100);
                } else {
                    $subject->price_discount = $subject->price - $discount->amount;
                }
                break;
            }
            $subject->lesson_count = $lessons;
        }
        foreach ($bundles as $bundle) {
            // Manually add price after discount
            foreach ($bundle->discount as $discount) {
                if ( $discount->type == 'precentage' ) {
                    $bundle->price_discount = $bundle->price - ($bundle->price * $discount->amount / 100);
                } else {
                    $bundle->price_discount = $bundle->price - $discount->amount;
                }
                break;
            }
        }        
        $live = $this->live
        ->where('category_id', $student->category_id)
        ->where('education_id', $student->education_id)
        ->whereDoesntHave('students', function ($query) use($student) {
            $query->where('users.id', $student->id);
        })
        ->where('inculded', 0)
        ->where('date', '>=', now())
        ->orWhereNull('education_id')
        ->where('category_id', $student->category_id)
        ->whereDoesntHave('students', function ($query) use($student) {
            $query->where('users.id', $student->id);
        })
        ->where('inculded', 0)
        ->where('date', '>=', now())
        ->orWhereIn('subject_id', $subjects->pluck('id'))
        ->where('inculded', 1)
        ->where('date', '>=', date('Y-m-d'))
        ->get(); // Get live that havs the same category of student
        $payment_methods = $this->payment_method
        ->get();
        $categories = $this->categories
        ->get();
        $education = $this->education
        ->get();

        $bundles = $bundles->where('status', 1)
        ->where('expired_date', '>=', date('Y-m-d'));
        $subjects = $subjects->where('status', 1)
        ->where('expired_date', '>=', date('Y-m-d'));
        return response()->json([
            'bundles' => $bundles,
            'subjects' => $subjects,
            'live' => $live,
            'payment_methods' => $payment_methods,
            'categories' => $categories,
            'education' => $education,
        ]);
    }

    public function add_purchases(){
        
    }
}
