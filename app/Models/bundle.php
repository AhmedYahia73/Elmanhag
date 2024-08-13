<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\subject;

class bundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'          ,
        'price'         ,
        'discount'      ,
        'category_id'   ,
        'education_id'  ,
        'expired_date'  ,
        'discount_type' ,
    ];

    public function users(){
        return belongsToMany(User::class, 'students_bundles');
    }

    public function subjects(){
        return belongsToMany(subject::class, 'bundles_subjects');
    }
}
