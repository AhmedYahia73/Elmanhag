<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class LoginHistory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'os',
        'browser',
        'device',
        'ip',
        'country',
        'city',
        'location',
        'start_session',
        'end_session',
        'duration',
        'user_id',
        'token_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
