<?php

namespace App\Http\Controllers;
use App\Models\Rewards;
use App\Models\NormalUser;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userdata = Rewards::where('userId',$id)->where('type','reward')->get();
        $userReferralTotal = Rewards::where('userId',$id)->where('type','referral')->sum('amount');
        $userReferrals = Rewards::where('userId',$id)->where('type','referral')->get();
        $referral = [];
        foreach ($userReferrals as $userReferral)
        {
            $referral[] = [
                'amount' => $userReferral->amount,
                'Referral User' => NormalUser::where('id',$userReferral['receive_from'])->first(),
                'time' => $userReferral->time
            ];
        }

        $data = [
            'reward' => $userdata,
            'referralTotal' => $userReferralTotal,
            'referral' => $referral
        ];

        if ( !Rewards::where('userId',$id)->first())
        {
            return response([
                'success' => false,
                'data' => 'No data Found',
                'message' => []
            ],200);

        }
        return response([
            'success' => true,
            'data' => 'Rewards Found Successfully',
            'message' => $data
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
