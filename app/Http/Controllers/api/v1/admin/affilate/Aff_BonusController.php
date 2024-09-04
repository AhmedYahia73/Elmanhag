<?php

namespace App\Http\Controllers\api\v1\admin\affilate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\affilate\BonusRequest;

use App\Models\Bonus;

class Aff_BonusController extends Controller
{
    public function __construct(private Bonus $bonus){}
    protected $bonusRequest = [
        'title',
        'target',
        'bonus'
    ];

    public function show(){
        $bonus = $this->bonus->get();

        return response()->json([
            'bonus' => $bonus
        ]);
    }

    public function add(BonusRequest $request){
        $bonus_data = $request->only($this->bonusRequest);
        $this->bonus
        ->create($bonus_data);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function update(BonusRequest $request, $id){
        $bonus_data = $request->only($this->bonusRequest);
        $this->bonus
        ->where('id', $id)
        ->update($bonus_data);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete($id){
        $this->bonus
        ->where('id', $id)
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
