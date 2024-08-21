<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'amount',
        'service',
        'student_id',
        'payment_method_id',
        'purchase_date',
        'rejected_reason',
        'status',
    ];
}
