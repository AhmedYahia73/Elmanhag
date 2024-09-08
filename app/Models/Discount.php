<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\category;
use App\Models\subject;
use App\Models\bundle;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'amount',
        'type',
        'description',
        'start_date',
        'end_date',
        'statue',
    ];

    public function category(){
        return $this->belongsTo(category::class);
    }

    public function subject(){
        return $this->belongsToMany(subject::class, 'discount_services');
    }

    public function bundle(){
        return $this->belongsToMany(bundle::class, 'discount_services');
    }
}
