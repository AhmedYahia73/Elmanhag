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

class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $fillable = [
        'firstName',
        'lastName',
        'phone',
        'type',
        'email',
        'email_verified_at',
        'password',
        'country_id',
        'city_id',
        'student_id',
        'remember_token',
        'parent_name',
        'parent_phone',
        'parent_kinship',
        'category_id',
        'language',
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

    public function city(){
        return $this->belongsTo(city::class);
    }

    public function getimageAttribute($date){
        return $this->image = url('storage/app/public/'.$date);
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

}
