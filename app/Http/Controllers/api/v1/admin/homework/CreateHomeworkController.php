<?php

namespace App\Http\Controllers\api\v1\admin\homework;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\homework\HomeworkRequest;

use App\Models\homework;

class CreateHomeworkController extends Controller
{
    public function __construct(private homework $homeworks){}
    public function create(HomeworkRequest $request){

    }
    
    public function modify(HomeworkRequest $request, $id){

    }

    public function delete($id){
        $this->homeworks->where('id', $id)
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
