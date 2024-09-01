<?php

namespace App\Http\Controllers\api\v1\admin\chapter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\trait\image;
use App\trait\translaion;
use App\Http\Requests\api\admin\chapter\ChapterRequest;

use App\Models\chapter;

class CreateChapterController extends Controller
{
    protected $chapterRequest = [
        'name',
        'ar_name'
    ];
    use image;
    use translaion;
    
    public function create(ChapterRequest $request, $sub_id){
        // https://bdev.elmanhag.shop/admin/chapter/add/{$sub_id}
        $chapter = $request->only($this->chapterRequest); // Get Date
        $cover_photo = $this->upload($request, 'cover_photo', 'admin/chapters/cover_photo'); // Upload cover photo
        $thumbnail = $this->upload($request, 'thumbnail', 'admin/chapters/thumbnail'); // Upload thumbnail
        $chapter['cover_photo'] = $cover_photo;
        $chapter['thumbnail'] = $thumbnail;
        $chapter['subject_id'] = $sub_id;
        $this->translate($chapter['name'], $chapter['ar_name']);// Translate in file json
        chapter::create($chapter);

        return response()->json([
            'success' => 'You added chapter success', 200
        ]);
    }

    public function modify(ChapterRequest $request, $id){
        // https://bdev.elmanhag.shop/admin/chapter/update/{$id}
        $chapterData = $request->only($this->chapterRequest); // Get Date
        $chapter = chapter::where('id', $id)
        ->first();
        $this->translate($chapterData['name'], $chapterData['ar_name']);// Translate in file json
 
        $cover_photo = $this->upload($request, 'cover_photo', 'admin/chapters/cover_photo'); // Upload cover photo
        $thumbnail = $this->upload($request, 'thumbnail', 'admin/chapters/thumbnail'); // Upload thumbnail
        // If new Cover Photo is found delete old image
        if ( !empty($cover_photo) && $cover_photo != null ) {
            $this->deleteImage($chapter->cover_photo);
            $chapterData['cover_photo'] =$cover_photo; // Image Value From traid Image 
        }
        // If new Thumbnail is found delete old image
        if ( !empty($thumbnail) && $thumbnail != null ) {
            $this->deleteImage($chapter->thumbnail);
            $chapterData['thumbnail'] =$thumbnail; // Image Value From traid Image 
        }
        $this->translate($chapterData['name'], $chapterData['ar_name']);// Translate in file json
        $chapter->update($chapterData);

        return response()->json([
            'success' => 'You Updated chapter success', 200
        ]);
    }
    
    public function delete( $id ){
        // https://bdev.elmanhag.shop/admin/chapter/delete/{$id}
        $chapter = chapter::where('id', $id)
        ->first();
        $this->deleteImage($chapter->cover_photo);
        $this->deleteImage($chapter->thumbnail);
        $chapter->delete();

        return response()->json([
            'success' => 'You deleted chapter success'
        ]);
    }
}
