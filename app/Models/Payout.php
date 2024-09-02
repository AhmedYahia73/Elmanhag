<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'date',
        'amount',
        'rejected_reason',
        'status',
        'affilate_id',
        'payment_method_affilate_id',
    ];



   
}
