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
        'status',
    ];

    public function create(PromocodeRequest $request){
        // Keys
        // title, code, status, value, precentage, usage_type, usage, number_users
        // subjects[], bundles[]
        $promocode_data = $request->only($this->promoCodeRequest);
        $promo_code = $this->promo_code->create($promocode_data); // create promo code
        // add subjects that have this promocode
        foreach ($request->subjects as $item) {
            $promo_code->subjects()->attach($item); // add subjects to pivot table
        }
        // add bundles that have this promocode
        foreach ($request->bundles as $item) {
            $promo_code->bundles()->attach($item); // add bundles to pivot table
        }

        return response()->json([
            'success' => 'you add data success'
        ]);
    }
    
    public function modify(PromocodeRequest $request, $id){
        
    }
    
    public function delete($id){
        $this->promo_code
        ->where('id', $id)
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
