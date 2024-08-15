<?php

namespace App\Http\Controllers\api\v1\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\settings\CitiesRequest;
use App\trait\translaion;

use App\Models\city;

class CitiesController extends Controller
{
    use translaion;
    protected $citiesReqest = [
        'name',
        'ar_name',
        'country_id',
        'status',
    ];

    public function show(){
        // https://bdev.elmanhag.shop/admin/Settings/cities
        // Get Data
        $cities = city::
        with('country')
        ->get();

        return response()->json([
            'cities' => $cities
        ]);
    }
    
    public function create( CitiesRequest $request ){
        // https://bdev.elmanhag.shop/admin/Settings/cities/add?name=Alexandria&ar_name=الاسكندرية&country_id=1&status=1
        // Get date at reqest
        $city_data = $request->only($this->citiesReqest);
        // Translate City at json file
        $this->translate($city_data['name'], $city_data['ar_name']);
        // Create city
        city::create($city_data);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }
    
    public function modify( CitiesRequest $request, $id ){
        // https://bdev.elmanhag.shop/admin/Settings/cities/update/1?name=Alexandria&ar_name=الاسكندرية&country_id=1&status=1
        // Get date at reqest
        $city_data = $request->only($this->citiesReqest);
        // Translate City at json file
        $this->translate($city_data['name'], $city_data['ar_name']);
        // Get city
        $city = city::where('id', $id)
        ->first();
        // Update City
        $city->update($city_data);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }
    
    public function delete( $id ){
        // https://bdev.elmanhag.shop/admin/Settings/cities/delete/1
        // Delete City
        city::where('id', $id)
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
