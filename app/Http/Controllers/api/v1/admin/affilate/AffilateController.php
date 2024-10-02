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
use App\Models\AffilateHistory;
use App\Models\Payout;
use App\Models\category;
use App\Models\LoginHistory;

class AffilateController extends Controller
{
    public function __construct(private User $user, private AffilateAccount $affilate_account,
    private country $country, private city $city, private AffilateHistory $affilate_histories
    , private category $category, private Payout $payout, private LoginHistory $login_history){}
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
        // https://bdev.elmanhag.shop/admin/affilate
        $affilates = $this->user
        ->where('role', 'affilate')
        ->orWhereNotNull('affilate_code')
        ->with(['income', 'logins'])
        ->withCount(['signups'])
        ->get();
        $total_affilate = count($affilates);
        $active_affilate = $this->user
        ->where('role', 'affilate')
        ->where('status', 1)
        ->orWhereNotNull('affilate_code')
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
        // https://bdev.elmanhag.shop/admin/affilate/add
        // Keys
        // name, phone, email, country_id, city_id, password, status
        $affilate_data = $request->only($this->affilateRequest);
        $affilate_data['role'] = 'affilate';
        $affilate_code = rand(100000, 999999);
        $db_affilate_code = $this->user->where('affilate_code', $affilate_code)
        ->first(); // get affilate that have the same code to check if code frequent
        while (!empty($db_affilate_code)) { // if code is exist it will changed
            $affilate_code = rand(100000, 999999);
            $db_affilate_code = $this->user->where('affilate_code', $affilate_code)
            ->first(); // get affilate that have the same code to check if code frequent
        }
        $affilate_data['affilate_code'] = $affilate_code;
        $affilate = $this->user->create($affilate_data);
        $this->affilate_account->create([
            'affilate_id' => $affilate->id
        ]);

        return response()->json([
            'success' => 'You add affilate success'
        ]);
    }

    public function modify(UpdateAffilateRequest $request, $id){
        // https://bdev.elmanhag.shop/admin/affilate/update/{id}
        // Keys
        // name, phone, email, country_id, city_id, password, status, image
        $affilate = $this->user->where('id', $id)
        ->where('role', 'affilate')
        ->orWhereNotNull('affilate_code')
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
        // https://bdev.elmanhag.shop/admin/affilate/banned/{id}
        $affilate = $this->user
        ->where('id', $id)
        ->where('role', 'affilate')
        ->orWhereNotNull('affilate_code')
        ->where('id', $id)
        ->update(['status' => 0]);

        return response()->json([
            'success' => 'You block affilate success'
        ]);
    }

    public function unblock($id){
        // https://bdev.elmanhag.shop/admin/affilate/unblock/{id}
        $affilate = $this->user->where('id', $id)
        ->where('role', 'affilate')
        ->orWhereNotNull('affilate_code')
        ->where('id', $id)
        ->update(['status' => 1]);

        return response()->json([
            'success' => 'You unblock affilate success'
        ]);
    }

    public function signups($affilate_id){
        // https://bdev.elmanhag.shop/admin/affilate/signups/{affilate_id}
        $signups = $this->user
        ->where('affilate_id', $affilate_id)
        ->with(['category', 'parents'])
        ->get();

        return response()->json([
            'signups' => $signups
        ]);
    }

    public function revenue($affilate_id){
        // https://bdev.elmanhag.shop/admin/affilate/revenue/{affilate_id}
        $categories = $this->category->get();
        $affilate_histories = $this->affilate_histories
        ->where('affilate_id', $affilate_id)
        ->with(['student', 'category', 'method'])
        ->get();

        return response()->json([
            'categories' => $categories,
            'affilate_histories' => $affilate_histories,
        ]);
    }

    public function payout($affilate_id){
        // https://bdev.elmanhag.shop/admin/affilate/payout/{affilate_id}
        $payouts = $this->payout
        ->where('status', null)
        ->where('affilate_id', $affilate_id)
        ->with('method')
        ->get();

        return response()->json([
            'payouts' => $payouts,
        ]);
    }

    public function approve_payout($payout_id){
        // https://bdev.elmanhag.shop/admin/affilate/payout/approve/{payout_id}
        $payout = $this->payout
        ->where('id', $payout_id)
        ->first();
        $affilate_account = $this->affilate_account
        ->where('affilate_id', $payout->affilate_id)
        ->first();

        if ($payout->amount > $affilate_account->wallet) {
            return response()->json([
                'faild' => 'You are asking for more than what is available'
            ]);
        }
        $affilate_account->update([
            'wallet' => $affilate_account->wallet - $payout->amount,
        ]);
        $payout->update([
            'status' => 1
        ]);

        return response()->json([
            'success' => 'You Approve Payout Success'
        ]);
    }

    public function rejected_payout(Request $request, $payout_id){
        // https://bdev.elmanhag.shop/admin/affilate/payout/rejected/{payout_id}
        // keys 
        // rejected_reason
        $payout = $this->payout
        ->where('id', $payout_id)
        ->first(); 
  
        $payout->update([
            'status' => 0,
            'rejected_reason' => $request->rejected_reason,
        ]);

        return response()->json([
            'success' => 'You Rejected Payout Success'
        ]);
    }

    public function payout_history($affilate_id){
        // https://bdev.elmanhag.shop/admin/affilate/payout_history/{id}
        $payouts = $this->payout
        ->where('status', '!=', null)
        ->where('affilate_id', $affilate_id)
        ->with('method')
        ->get();

        return response()->json([
            'payouts' => $payouts,
        ]);
    }

    public function login_history($id){
        // https://bdev.elmanhag.shop/admin/affilate/loginHistory/{id}
        $logins = $this->login_history
        ->where('user_id', $id)
        ->whereHas('user', function($query){
            $query->where('role', 'affilate')
            ->orWhereNotNull('affilate_code');
        })
        ->get();

        return response()->json([
            'logins' => $logins
        ]);
    }

}
