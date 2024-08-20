<?php

namespace App\Http\Controllers\api\v1\admin\promocode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\promocode\PromocodeRequest;

use App\Models\PromoCode;

class CreatePromocodeController extends Controller
{
    public function __construct(private PromoCode $promo_code){}
    protected $promoCodeRequest = [
        'title',
        'code',
        'value',
        'precentage',
        'usage_type',
        'usage',
        'number_users',
    ];

    public function create(PromocodeRequest $request){
        
    }
    
    public function modify(PromocodeRequest $request, $id){
        
    }
    
    public function delete($id){
        
    }
}
