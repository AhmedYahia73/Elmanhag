<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\country;

class city extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' ,
        'country_id',
        'status' ,
    ];

    public function country(){
        return $this->belongsTo(country::class);
    }

}
