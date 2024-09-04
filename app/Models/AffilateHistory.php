<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\category;
use App\Models\PaymentMethod;

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
        'affilate_id',
        'service_type',
    ];

    public function student(){
        return $this->belongsTo(User::class, 'student_id');
    }

    public function category(){
        return $this->belongsTo(category::class, 'category_id');
    }

    public function method(){
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
