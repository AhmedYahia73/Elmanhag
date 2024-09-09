<?php

namespace App\Http\Controllers\api\v1\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\trait\image;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

use App\Models\VideoIssues;

class VideoIssuesController extends Controller
{
    public function __construct(private VideoIssues $video_issues){}
    use image;
    protected $issuesRequest = [
        'title',
        'description',
        'status',
    ];

    public function show(){
        // https://bdev.elmanhag.shop/admin/Settings/videoIssues
        $video_issues = $this->video_issues->get();

        return response()->json([
            'video_issues' => $video_issues
        ]);
    }

    public function add(Request $request){
        // https://bdev.elmanhag.shop/admin/Settings/videoIssues/add
        // Keys
        // title, description, status, thumbnail
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'status' => 'required|boolean',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
        $issues_data = $request->only($this->issuesRequest); // Get data of question request
        $thumbnail = $this->upload($request,'thumbnail','admin/videoIssues/thumbnail'); // Upload Thumbnail
        if (!empty($thumbnail) && $thumbnail != null) {
            $issues_data['thumbnail'] = $thumbnail;
        }
        $this->video_issues->create($issues_data); // create question issues

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(Request $request, $id){
        // https://bdev.elmanhag.shop/admin/Settings/videoIssues/update/{id}
        // Keys
        // title, description, status, thumbnail
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'status' => 'required|boolean',
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }
        $issues_data = $request->only($this->issuesRequest); // Get data of question request
        $thumbnail = $this->upload($request,'thumbnail','admin/videoIssues/thumbnail'); // Upload Thumbnail
        if (!empty($thumbnail) && $thumbnail != null) {
            $issues_data['thumbnail'] = $thumbnail;
        }
        $video_issues = $this->video_issues
        ->where('id', $id)
        ->first(); // Get question issue
        $this->deleteImage($video_issues->thumbnail);
        $video_issues->update($issues_data); // Update question issues

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete($id){
        // https://bdev.elmanhag.shop/admin/Settings/videoIssues/delete/{id}
        $video_issues = $this->video_issues
        ->where('id', $id)
        ->first();
        if (isset($video_issues->thumbnail)) {
            $this->deleteImage($video_issues->thumbnail);
        }
        $video_issues->delete();

        return response()->json([
            'success' => 'Data deleted success'
        ]);
    }
}
