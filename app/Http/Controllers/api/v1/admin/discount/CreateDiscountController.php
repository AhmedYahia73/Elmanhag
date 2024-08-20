<?php

namespace App\Http\Controllers\api\v1\admin\discount;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\discount\DiscountRequest;

use App\Models\Discount;

class CreateDiscountController extends Controller
{
    public function __construct(private Discount $discount){}
    protected $discountRequest = [
        'category_id',
        'subject_id',
        'bundle_id',
        'amount',
        'type',
        'description',
        'start_date',
        'end_date',
        'statue',
    ];
    public function create(DiscountRequest $request){
        $dicount_data = $request->only($this->discountRequest);
        $this->discount->create($dicount_data);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(DiscountRequest $request, $id){
        $dicount_data = $request->only($this->discountRequest);
        $this->discount->where('id', $id)
        ->update($dicount_data);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete($id){
        $this->discount->where('id', $id)
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
