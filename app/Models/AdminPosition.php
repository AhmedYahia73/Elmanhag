<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\AdminRole;

class AdminPosition extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name' ,
    ];

    public function roles(){
        return $this->hasMany(AdminRole::class, 'admin_position_id');
    }
}
