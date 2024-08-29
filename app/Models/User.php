<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\subject;
use App\Models\bundle;
use App\Models\category;
use App\Models\country;
use App\Models\city;
use App\Models\Education;
use Illuminate\Auth\Authenticatable as AuthAuthenticatable;

class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable,AuthAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $fillable = [
        'name',
        'phone',
        'role',
        'gender',
        'sudent_jobs_id',
        'affiliate_id',
        'email',
        'email_verified_at',
        'password',
        'country_id',
        'city_id',
        'student_id',
        'remember_token',
        'parent_relation_id',
        'category_id',
        'education_id',
        'image',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $image_url;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getImageUrl (){
        if($this->image){
            return $this->image = url('storage/app/public/'.$this->image);
        }
        return 'C:\xampp\tmp'.$this->name;
    }

    public function country(){
        return $this->belongsTo(country::class);
    }

    public function education(){
        return $this->belongsTo(Education::class);
    }

    public function city(){
        return $this->belongsTo(city::class);
    }

    public function getimageAttribute($data){
    
        return $this->image = [
            'path'=>$data,
            'url'=> url('storage/'.$data) ?? url('storage/'.'default.png'),
        ];
   
    }

    public function subjects(){
        return $this->belongsToMany(subject::class, 'students_subjects');
    }

    public function bundles(){
        return $this->belongsToMany(bundle::class, 'students_bundles');
    }
   

    public function category(){
        return $this->belongsTo(category::class, 'category_id');
    }

    public function parents(){
        return $this->hasMany(User::class,'student_id');
    }

    public function teacher_subjects(){
        return $this->belongsToMany(subject::class, 'teacher_subject');
    }
    public function student_jobs(){
        return $this->belongsToMany(StudentJob::class, 'teacher_subject');
    }

}
