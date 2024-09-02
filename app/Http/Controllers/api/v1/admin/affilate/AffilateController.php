<?php

namespace App\Http\Controllers\api\v1\admin\affilate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\api\admin\affilate\AffilateRequest;
use App\Http\Requests\api\admin\affilate\UpdateAffilateRequest;
use App\trait\image;

use App\Models\User;
use App\Models\AffilateAccount;
use App\Models\country;
use App\Models\city;

class AffilateController extends Controller
{
    public function __construct(private User $user, private AffilateAccount $affilate_account,
    private country $country, private city $city){}
    use image;
    protected $affilateRequest = [
        'name',
        'phone',
        'email',
        'country_id',
        'city_id',
        'password',
        'status',
    ];

    public function affilate(){
        $affilates = $this->user
        ->where('role', 'affilate')
        ->with(['income', 'logins'])
        ->withCount(['signups'])
        ->get();
        $total_affilate = count($affilates);
        $active_affilate = $this->user
        ->where('role', 'affilate')
        ->where('status', 1)
        ->count();
        $revenue = $this->affilate_account
        ->sum('income');
        $wallets = $this->affilate_account
        ->sum('wallet');
        $sign_ups = $this->user
        ->where('affilate_id', '!=', null)
        ->count();
        $countries = $this->country->get();
        $cities = $this->city->get();

        return response()->json([
            'affilates' => $affilates,
            'total_affilate' => $total_affilate,
            'active_affilate' => $active_affilate,
            'revenue' => $revenue,
            'wallets' => $wallets,
            'sign_ups' => $sign_ups,
            'countries' => $countries,
            'cities' => $cities,
        ]);
    }

    public function create(AffilateRequest $request){
        // Keys
        // name, phone, email, country_id, city_id, password, status
        $affilate_data = $request->only($this->affilateRequest);
        $affilate_data['role'] = 'affilate';
        $affilate = $this->user->create($affilate_data);
        $this->affilate_account->create([
            'affilate_id' => $affilate->id
        ]);

        return response()->json([
            'success' => 'You add affilate success'
        ]);
    }

    public function modify(UpdateAffilateRequest $request, $id){
        // Keys
        // name, phone, email, country_id, city_id, password, status, image
        $affilate = $this->user->where('id', $id)
        ->where('role', 'affilate')
        ->first();
        $affilate_data = $request->only($this->affilateRequest);
        $image_path = $this->upload($request, 'image', 'affilate/users');
        if (!empty($image_path) && $image_path != null) {
            $affilate_data['image'] = $image_path;
        }
        $affilate->update($affilate_data);

        return response()->json([
            'success' => 'You update affilate success'
        ]);
    }

    // public function delete($id){
    //     $affilate = $this->user->where('id', $id)
    //     ->first();
    //     $this->deleteImage($affilate->image);
    //     $affilate->delete();

    //     return response()->json([
    //         'success' => 'You delete affilate success'
    //     ]);
    // }
    
    public function banned($id){
        $affilate = $this->user->where('id', $id)
        ->where('role', 'affilate')
        ->update(['status' => 0]);

        return response()->json([
            'success' => 'You block affilate success'
        ]);
    }

    public function unblock($id){
        $affilate = $this->user->where('id', $id)
        ->where('role', 'affilate')
        ->update(['status' => 1]);

        return response()->json([
            'success' => 'You unblock affilate success'
        ]);
    }
}
