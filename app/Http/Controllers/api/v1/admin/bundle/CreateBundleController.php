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
    use image;
    use translaion;
    protected $bundleRequest = [
        'name',
        'ar_name',
        'tags',
        'url',
        'description',
        'price',
        'semester',
        'category_id',
        'education_id',
        'expired_date',
        'status',
    ];
    public function __construct(private bundle $bundle){}

    public function create(BundleRequest $request){
        // https://bdev.elmanhag.shop/admin/bundle/add
        // keys 
        // name, ar_name, price, semester [first, second], category_id, education_id, expired_date, status
        // tags, thumbnail, cover_photo, demo_video, url, description
        // subjects[]
        $bundle_data = $request->only($this->bundleRequest);
        $demo_video = $this->upload($request,'demo_video','admin/bundles/demo_video'); // Upload Demo Video
        $cover_photo = $this->upload($request,'cover_photo','admin/bundles/cover_photo'); // Upload Cover Photo
        $thumbnail = $this->upload($request,'thumbnail','admin/bundles/thumbnail'); // Upload thumbnail
        $this->translate($bundle_data['name'], $bundle_data['ar_name']);
        $bundle_data['demo_video'] = $demo_video;
        $bundle_data['cover_photo'] = $cover_photo;
        $bundle_data['thumbnail'] = $thumbnail;
        $bundle = $this->bundle->create($bundle_data);
        $bundle->subjects()->sync($request->subjects);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(BundleRequest $request, $id){
        // https://bdev.elmanhag.shop/admin/bundle/update/{id}
        // keys 
        // name, ar_name, price, semester [first, second], category_id, education_id, expired_date, status
        // tags, thumbnail, cover_photo, demo_video, url, description
        // subjects[]
        $bundle_data = $request->only($this->bundleRequest);
        $this->translate($bundle_data['name'], $bundle_data['ar_name']);
        $bundle = $this->bundle->where('id', $id)
        ->first();
        $bundle->subjects()->sync($request->subjects);
        $demo_video = null;
        $cover_photo = null;
        $thumbnail = null;
        if ($request->demo_video != $bundle->demo_video_link) {
            $demo_video = $this->upload($request,'demo_video','admin/bundles/demo_video'); // Upload Demo Video
        }
        if ($request->cover_photo != $bundle->cover_photo_link) {
            $cover_photo = $this->upload($request,'cover_photo','admin/bundles/cover_photo'); // Upload Cover Photo
        }
        if ($request->thumbnail != $bundle->thumbnail_link) {
            $thumbnail = $this->upload($request,'thumbnail','admin/bundles/thumbnail'); // Upload thumbnail
        }
        // If new Video is found delete old image
        if ( !empty($demo_video) && $demo_video != null ) {
            $this->deleteImage($bundle->demo_video);
            $bundle_data['demo_video'] =$demo_video; // Image Value From traid Image 
        }
        // If new image is found delete old image
        if ( !empty($cover_photo) && $cover_photo != null ) {
            $this->deleteImage($bundle->cover_photo);
            $bundle_data['cover_photo'] =$cover_photo; // Image Value From traid Image 
        }
        // If new image is found delete old image
        if ( !empty($thumbnail) && $thumbnail != null ) {
            $this->deleteImage($bundle->thumbnail);
            $bundle_data['thumbnail'] =$thumbnail; // Image Value From traid Image 
        }
        $bundle->update($bundle_data);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete( $id ){
        // https://bdev.elmanhag.shop/admin/bundle/delete/1
        $bundle = $this->bundle->where('id', $id)
        ->first();
        if (empty($bundle)) { 
            return response()->json([
                'faild' => 'bundle is not found'
            ]);
        }
        $this->deleteImage($bundle->demo_video); // delete demo video
        $this->deleteImage($bundle->cover_photo); // delete cover photo
        $this->deleteImage($bundle->thumbnail); // delete thumbnail
        $bundle->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
