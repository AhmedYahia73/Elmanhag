<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFawryPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'payment_id',
        'orderstatus',
        'merchantRefNum',
    ];
}
