<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\subject;
use App\Models\bundle;

class PromoCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'title' ,
        'code' ,
        'value' ,
        'precentage' ,
        'usage_type' ,
        'usage' ,
        'number_users' ,
        'status',
    ];

    public function subjects(){
        return $this->belongsToMany(subject::class, 'promo_code_subjects');
    }
    
    public function bundles(){
        return $this->belongsToMany(bundle::class, 'promo_code_bundles');
    }
}
