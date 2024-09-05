<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Bonus extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'target',
        'bonus',
        'image',
    ];

    public function affilate(){
        return $this->belongsToMany(User::class, 'affilate_bonuses', 'bonus_id', 'affilate_id');
    }
}
