<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\bundle;
use App\Models\subject;
use App\Models\Live;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Payment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'amount',
        'service',
        'student_id',
        'payment_method_id',
        'purchase_date',
        'merchantRefNum',
        'receipt',
        'rejected_reason',
        'status',
    ];
    protected $appends = ['receipt_link'];

    public function getReceiptLinkAttribute(){
        return url('storage/' . $this->attributes['receipt']);
    }
    
    public function student(){
        return $this->belongsTo(User::class, 'student_id');
    }

    public function payment_method(){
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function bundle(){
        return $this->belongsToMany(bundle::class, 'service_payment');
    }

    public function subject(){
        return $this->belongsToMany(subject::class, 'service_payment');
    }

    public function live():BelongsToMany{
        return $this->belongsToMany(Live::class, 'service_payment');
    }

    public function recorded_live():BelongsToMany{
        return $this->belongsToMany(LiveRecorded::class, 'service_payment', 'payment_id', 'recorded_id');
    }
}
