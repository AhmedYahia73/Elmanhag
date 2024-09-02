<?php

namespace App\Http\Controllers\api\v1\admin\affilate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\AffilateAccount;
use App\Models\country;
use App\Models\city;

class AffilateController extends Controller
{
    public function __construct(private User $user, private AffilateAccount $affilate_account,
    private country $country, private city $city){}

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

    public function create(){
        
    }
}
