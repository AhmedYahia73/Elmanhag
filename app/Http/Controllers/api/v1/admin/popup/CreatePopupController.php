<?php

namespace App\Http\Controllers\api\v1\admin\popup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\popup\PopupRequest;
use App\Http\Requests\api\admin\popup\UpdatePopupRequest;
use App\trait\image;
use App\trait\translaion;

use App\Models\Popup;

class CreatePopupController extends Controller
{
    public function __construct(private Popup $popup){}
    use image;
    use translaion;
    protected $popupRequest = [
        'title',
        'ar_title',
        'destination',
        'start_date',
        'end_date',
    ];
// image
    public function create(PopupRequest $request){
        $data = $request->only($this->popupRequest);
        $this->translate($data['title'], $data['ar_title']); // Translate at file json   
        $image =  $this->upload($request,'image','admin/popup'); // Upload popup
        $data['image'] = $image;
        $this->popup
        ->create($data);

        return response()->json([
            'success' => 'You add data success'
        ], 200);
    }

    public function modify(UpdatePopupRequest $request, $id){
        $data = $request->only($this->popupRequest);
        $this->translate($data['title'], $data['ar_title']); // Translate at file json   
        $popup = $this->popup
        ->where('id', $id)
        ->first();
        if (is_file($request->image)) {
            $image =  $this->upload($request,'image','admin/popup'); // Upload popup
            $this->deleteImage($popup->image);
            $data['image'] = $image;
        } // if admin upload file

        $popup->update($data);
        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete($id){
        
    }
}
