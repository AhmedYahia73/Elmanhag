<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\bundle;
use App\Models\subject;

class Payment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'amount',
        'service',
        'student_id',
        'payment_method_id',
        'purchase_date',
        'receipt',
        'rejected_reason',
        'status',
    ];

    public function student(){
        return $this->belongsTo(User::class, 'student_id');
    }

    public function payment_method(){
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function bundle(){
        return $this->belongsTo(bundle::class, 'service_payment');
    }

    public function subject(){
        return $this->belongsTo(subject::class, 'service_payment');
    }
}
