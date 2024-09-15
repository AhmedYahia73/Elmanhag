<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint',
        'user_id' ,
    ];

    public function student(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
