<?php

namespace App\Http\Controllers\api\v1\admin\bundle;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\trait\image;
use App\trait\translaion;
use App\Http\Requests\api\admin\bundle\BundleRequest;

use App\Models\bundle;

class CreateBundleController extends Controller
{
    use translaion;
    protected $bundleRequest = [
        'name',
        'ar_name',
        'price',
        'semester',
        'category_id',
        'education_id',
        'expired_date'
    ];

    public function create(BundleRequest $request){
        $bundle_data = $request->only($this->bundleRequest);
        $this->translate($bundle_data['name'], $bundle_data['ar_name']);
        bundle::create($bundle_data);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(BundleRequest $request, $id){
        $bundle_data = $request->only($this->bundleRequest);
        $this->translate($bundle_data['name'], $bundle_data['ar_name']);
        $bundle = bundle::where('id', $id)
        ->first();
        $bundle->update($bundle_data);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete( $id ){
        bundle::where('id', $id)
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
