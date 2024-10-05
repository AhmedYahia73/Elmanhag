<?php

namespace App\Http\Controllers\api\v1\admin\revision;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\revision\RevisionRequest;

use App\Models\Revision;
use App\Models\RevisionQuestionGroup;

class CreateRevisionController extends Controller
{
    public function __construct(private Revision $revisions, private RevisionQuestionGroup $question_groups){}
    protected $revisionRequest = [
        'title',
        'semester',
        'category_id',
        'subject_id',
        'mark',
        'type',
        'month',
        'status',
    ];

    public function create(RevisionRequest $request){
        // https://bdev.elmanhag.shop/admin/revisions/add
        // Keys 
        // title, semester[first, second], category_id, subject_id, mark, type[monthly, final], month, status
        // groups[$iteration]
        // questions[$iteration][]
        $revision_data = $request->only($this->revisionRequest); // Get Data
        $revision = $this->revisions->create($revision_data); // Create revisions
        if ($request->groups) {
            foreach ($request->groups as $key => $item) { 
                $group = $this->question_groups->create([
                    'name' => $item,
                    'revision_id' => $revision->id
                ]);
    
                foreach ($request->questions[$key] as $element) {
                    $group->questions()->attach($element);
                }
            }
        }

        return response()->json([
            'success' => 'You add data success'
        ]);
    }
    
    public function modify(RevisionRequest $request, $id){
        // https://bdev.elmanhag.shop/admin/revisions/update/{id}
        // Keys 
        // title, semester[first, second], category_id, subject_id, mark, type[monthly, final], month, status
        // groups[$iteration]
        // questions[$iteration][]
        $revision_data = $request->only($this->revisionRequest);
        $revision = $this->revisions->where('id', $id)
        ->first()
        ->update($revision_data);
        $this->question_groups->where('revision_id', $id)
        ->delete();
        if ($request->groups) {
            foreach ($request->groups as $key => $item) { 
                $group = $this->question_groups->create([
                    'name' => $item,
                    'revision_id' => $id
                ]);

                foreach ($request->questions[$key] as $element) {
                    $group->questions()->attach($element);
                }
            }
        }

        return response()->json([
            'success' => 'You Update data success'
        ]);
    }

    public function delete($id){
        // https://bdev.elmanhag.shop/admin/revisions/delete/{id}
        $this->revisions->where('id', $id)
        ->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
