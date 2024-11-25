<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevisionVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'revision_id',
        'file',
        'type',
    ];
    protected $appends = ['file_link'];

    public function getFileLinkAttribute(){
        return url('storage/' . $this->attributes['file']);
    }
}
