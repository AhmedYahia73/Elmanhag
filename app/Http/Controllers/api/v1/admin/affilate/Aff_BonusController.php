<?php

namespace App\Http\Controllers\api\v1\admin\affilate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\affilate\BonusRequest;
use App\trait\image;

use App\Models\Bonus;
use App\Models\User;

class Aff_BonusController extends Controller
{
    use image;
    public function __construct(private Bonus $bonus, private User $users){}
    protected $bonusRequest = [
        'title',
        'target',
        'bonus',
    ];

    public function affilates(){
        $affilates = $this->users
        ->where('role', 'affilate')
        ->with('bonuses')
        ->get();

        return response()->json([
            'affilates' => $affilates
        ]);
    }

    public function show(){
        // https://bdev.elmanhag.shop/admin/affilate/bonus
        $bonus = $this->bonus->get();

        return response()->json([
            'bonus' => $bonus
        ]);
    }

    public function add(BonusRequest $request){
        // https://bdev.elmanhag.shop/admin/affilate/bonus/add
        // Keys
        // title, target, bonus, image
        $bonus_data = $request->only($this->bonusRequest);
        if (isset($request->image) && !empty($request->image)) {
            $image = $this->upload($request,'image','admin/affilate/bonus'); // Upload Image
            $bonus_data['image'] = $image;
        }
        $this->bonus
        ->create($bonus_data);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function update(BonusRequest $request, $id){
        // https://bdev.elmanhag.shop/admin/affilate/bonus/update/{id}
        // Keys
        // title, target, bonus, image
        $bonus_data = $request->only($this->bonusRequest);
        $bonus = $this->bonus
        ->where('id', $id)
        ->first();
        if (isset($request->image) && !empty($request->image)) {
            $image = $this->upload($request,'image','admin/affilate/bonus'); // Upload Image
            // If new image is found delete old image
            if ( !empty($image) && $image != null ) {
                $this->deleteImage($bonus->image);
                $bonus_data['image'] = $image; // Image Value From traid Image 
            }
        }
        $bonus->update($bonus_data);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete($id){
        // https://bdev.elmanhag.shop/admin/affilate/bonus/delete/{id}
        $bonus = $this->bonus
        ->where('id', $id)
        ->first();
        $this->deleteImage($bonus->image);
        $bonus->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
