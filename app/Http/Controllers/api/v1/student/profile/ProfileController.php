<?php

namespace App\Http\Controllers\api\v1\student\profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\student\profile\ProfileUpdateRequest;
use App\Models\User;
use App\trait\image;
use DragonCode\Support\Facades\Filesystem\File;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
     protected $requestProfile = [
               'name',
               'email',
               'password',
               'phone',
               'city_id',
               'sudent_jobs_id',
               'gender',
               'country_id',
               'category_id',
               'role',
               'image',
               'parent_relation_id',
               'education_id',
               'language'
     ];
         protected $parentRequest = [
         'parent_name' ,
         'parent_email' ,
         'parent_password',
         'parent_phone' ,
         'parent_role' ,
         'parent_id' ,
         'parent_relation_id',
         ];
    public function __construct(private User $user){}
    // This Controller About Profile Student
    use image;
    public function profile(Request $request){
        $user_id = $request->user()->id;
        $user = $request->user()
        ->with('studentJobs')
        ->with('parents')
        ->where('id',$user_id )
        ->first();
            try {
                $user->edu = $user->education->name;
                $user->country_name = $user->country->name;
                $user->city_name = $user->city->name;
                $user->category = $user->category->name;

            } catch (QueryException $th) {
            return response()->json([
                'faield'=>'This user Don\'t have City  ',
            ]);
            }
        return response()->json([
            'success'=>'Hello '.$request->user()->name,
            'user'=>$user,
        ]);
    }
    public function update(ProfileUpdateRequest $request){
        $user_id = $request->user()->id;
        $user = $this->user::findOrFail($user_id);
      $updateProfile = $request->only($this->requestProfile);
                $user->name = $updateProfile['name'] ?? $user->name;
                $user->email = $updateProfile['email'] ?? $user->email ;
                $image_path = $this->upload($request, 'image', 'student/user');
                $user->image = $image_path ?? $user->image;
                if( isset($updateProfile['password'])){
                    $user->password = $updateProfile['password'] ;
                }
                if ($user->image != 'female.png' && $user->image != 'default.png' && $image_path) {
                    $this->deleteImage($user->image);
                }
                $user->phone = $updateProfile['phone'] ?? $user->phone ;
                $user->parent_relation_id = $updateProfile['parent_relation_id'] ?? $user->parent_relation_id ;
                $user->education_id = $updateProfile['education_id'] ?? $user->education_id;
                $user->role = 'student';
                $user->city_id = $updateProfile['city_id']?? $user->city_id;
                $user->country_id = $updateProfile['country_id']?? $user->country_id;
                $user->category_id = $updateProfile['category_id']?? $user->category_id;
                $user->save();
               
                        return response()->json([
                            'success'=>'Data Updated Successfully',
                            ]);
    }


    public function delete_account(Request $request){
        $user = $request->user();
        if($user->delete()){
            return response()->json([
                'success'=>'Account Deleted Successfully',
            ]);
        }            
    }
}
