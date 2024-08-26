<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'thumbnail',
        'description',
        'status',
    ];
    protected $appends = ['thumbnail_link'];

    public function getThumbnailLinkAttribute(){
        return url('storage/' . $this->attributes['thumbnail']);
    }
}
