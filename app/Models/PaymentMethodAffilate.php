<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodAffilate extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'method',
        'min_payout',
        'thumbnail',
        'status',
    ];
}
