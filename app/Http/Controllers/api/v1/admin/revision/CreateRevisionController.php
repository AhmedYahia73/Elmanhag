<?php

namespace App\Http\Controllers\api\v1\admin\revision;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\revision\RevisionRequest;
use App\trait\image;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

use App\Models\Revision;
use App\Models\RevisionVideo;

class CreateRevisionController extends Controller
{
    public function __construct(private Revision $revisions, private RevisionVideo $revision_video){}
    protected $revisionRequest = [
        'title',
        'semester',
        'education_id',
        'category_id',
        'subject_id',
        'price',
        'type',
        'month',
        'expire_date',
        'status',
    ];
    use image;

    public function create(RevisionRequest $request){
        // https://bdev.elmanhag.shop/admin/revisions/add
        // Keys 
        // title, semester[first, second], education_id, category_id, subject_id, price, 
        // type[monthly, final], month, expire_date, status
        // files[{file, type => [video, pdf]}]
        $revision_data = $request->only($this->revisionRequest); // Get Data
        $revision = $this->revisions->create($revision_data); // Create revisions
        if ($request->files) {
            foreach ($request['files'] as $item) {
                if ($item['type'] == 'video') {
                    $file_path = $this->uploadFile($item['file'],'admin/revisions/video'); // Upload image
                } 
                else {
                    $file_path = $this->uploadFile($item['file'],'admin/revisions/file'); // Upload image
                }
                $this->revision_video->create([
                    'file' => $file_path,
                    'type' => $item['type'],
                    'revision_id' => $revision->id
                ]);
            }
        }

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(RevisionRequest $request, $id){
        // https://bdev.elmanhag.shop/admin/revisions/update/{id}
        // Keys 
        // title, semester[first, second], education_id, category_id, subject_id, price, 
        // type[monthly, final], month, expire_date, status
        $revision_data = $request->only($this->revisionRequest);
        $revision = $this->revisions->where('id', $id)
        ->first();
        $revision->update($revision_data);

        return response()->json([
            'success' => 'You Update data success'
        ]);
    }

    public function add_video(Request $request, $id){
        // https://bdev.elmanhag.shop/admin/revisions/file/add/{id}
        // Keys
        // file, type => [video, pdf]
        $validator = Validator::make($request->all(), [
            'file' => 'required',
            'type' => 'required|in:video,pdf',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
        if ($request->type == 'video') {
            $file_path = $this->uploadFile($request->file,'admin/revisions/video'); // Upload image
        } 
        else {
            $file_path = $this->uploadFile($request->file,'admin/revisions/file'); // Upload image
        }
        $this->revision_video->create([
            'file' => $file_path,
            'type' => $request->type,
            'revision_id' => $id
        ]);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function delete_video($id){
        // https://bdev.elmanhag.shop/admin/revisions/file/delete/{id}
        $revision_video = $this->revision_video
        ->where('id', $id)
        ->first();
        $this->deleteImage($revision_video->file);
        $revision_video->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }

    public function delete($id){
        // https://bdev.elmanhag.shop/admin/revisions/delete/{id}
        $revision = $this->revisions
        ->where('id', $id)
        ->first();
        $revision_video = $this->revision_video
        ->where('revision_id', $id)
        ->get();
        foreach ($revision_video as $item) {
            $this->deleteImage($item->file);
        }
        $revision->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
