<?php

namespace App\Http\Controllers\api\v1\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\trait\translaion;
use App\Http\Requests\api\admin\settings\RelationRequest;

use App\Models\ParentRelation;

class RelationController extends Controller
{
    use translaion;
    protected $relationRequest = [
        'name',
        'ar_name'
    ];

    public function show(){
        // Get Data
        $relations = ParentRelation::get();

        return response()->json([
            'relations' => $relations
        ]);
    }

    public function create( RelationRequest $request ){
        $relation_data = $request->only($this->relationRequest);
        $this->translate($relation_data['name'], $relation_data['ar_name']);
        ParentRelation::create($relation_data);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify( RelationRequest $request, $id ){
        $relation_data = $request->only($this->relationRequest);
        $this->translate($relation_data['name'], $relation_data['ar_name']);
        $relation = ParentRelation::
        where('id', $id)
        ->first();

        $relation->update($relation_data);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete( $id ){
        ParentRelation::
        where('id', $id)
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
