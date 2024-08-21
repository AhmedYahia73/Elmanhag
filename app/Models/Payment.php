<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\PaymentMethod;

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

    public function student(){
        return $this->belongsTo(User::class, 'student_id');
    }

    public function payment_method(){
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
