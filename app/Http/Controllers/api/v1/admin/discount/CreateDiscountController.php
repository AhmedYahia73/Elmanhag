<?php

namespace App\Http\Controllers\api\v1\admin\discount;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\discount\DiscountRequest;

use App\Models\Discount;

class CreateDiscountController extends Controller
{
    public function __construct(private Discount $discount){}
    public function create(DiscountRequest $request){

    }

    public function modify(DiscountRequest $request, $id){

    }

    public function delete($id){
        
    }
}
