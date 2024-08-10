<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'subject_id',
        'bundle_id',
        'amount',
        'type',
        'description',
        'start_date',
        'end_date',
        'statue',
    ];
}
