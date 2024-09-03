<?php

namespace App\Http\Controllers\api\v1\admin\affilate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

use App\Models\AffilateCommession;

class Aff_CommessionController extends Controller
{
    public function __construct(private AffilateCommession $commession){}

    public function commession(){
        $commession = $this->commession->first();

        return response()->json([
            'commession' => $commession
        ]);
    }

    public function add_commession(Request $request){
        
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:fixed,percentage',
            'amount' => 'required|numeric'
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                    'error' => $validator->errors(),
            ],400);
        }

        $commession = $this->commession->first();
        if (!empty($commession)) {
            $commession->update([
                'type' => $request->type,
                'amount' => $request->amount,
            ]);
        }
        else {
            $this->commession->create([
                'type' => $request->type,
                'amount' => $request->amount,
            ]);
        }

        return response()->json([
            'success' => 'You update commession success'
        ]);
    }
}
