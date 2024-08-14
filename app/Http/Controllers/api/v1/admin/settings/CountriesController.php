<?php

namespace App\Http\Controllers\api\v1\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\trait\translaion;
use App\Http\Requests\api\admin\settings\CountriesRequest;

use App\Models\country;

class CountriesController extends Controller
{
    use translaion;
    protected $countriesRequest = [
        'name',
        'ar_name',
        'status',
    ];

    public function show(){
        $countries = country::get();

        return response()->json([
            'countries' => $countries
        ]);
    }

    public function create( CountriesRequest $request ){
        $countries_data = $request->only($this->countriesRequest);
        $this->translate($countries_data['name'], $countries_data['ar_name']);
        country::create($countries_data);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify( CountriesRequest $request, $id ){
        $countries_data = $request->only($this->countriesRequest);
        $this->translate($countries_data['name'], $countries_data['ar_name']);
        $country = country::where('id', $id)
        ->first();
        $country->update($countries_data);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete( $id ){
        $country = country::where('id', $id)
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
