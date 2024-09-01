<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffilateHistory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'date',
        'student_id',
        'category_id',
        'service',
        'price',
        'payment_method_id',
        'commission',
    ];
}
