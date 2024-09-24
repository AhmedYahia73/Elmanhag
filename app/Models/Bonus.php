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
    protected $appends = ['image_link'];

    public function affilate(){
        return $this->belongsToMany(User::class, 'affilate_bonuses', 'bonus_id', 'affilate_id');
    }

    public function getImageLinkAttribute(){
        if (!empty($this->attributes['image'])) {
            return url('storage/' . $this->attributes['image']);
        } else {
            return null;
        }
        
    }
}
