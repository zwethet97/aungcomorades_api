<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Referrals;
use App\Models\BetSlip;
use App\Models\Rewards;
use App\Models\NormalUser;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TwodReferralController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $currentDay = Carbon::now('Asia/Yangon')->format('d');
        $currentMonth = Carbon::now('Asia/Yangon')->format('m');
        $currentYear = Carbon::now('Asia/Yangon')->format('Y');
        $currentHour = Carbon::now('Asia/Yangon')->format('H');
        $currentMin = Carbon::now('Asia/Yangon')->format('i');
        $currentSec = Carbon::now('Asia/Yangon')->format('s');
        $date = Carbon::now('Asia/Yangon');
        $date->setISODate($currentYear,$date->weekOfYear);
        $start = $date->startOfWeek()->format('d.m.Y');
        $end = $date->endOfWeek()->format('d.m.Y');
        $now = Carbon::now('Asia/Yangon')->format('l');

        $current = Carbon::create($currentYear,$currentMonth,$currentDay,$currentHour,$currentMin,$currentSec,'Asia/Yangon');
        $even = Carbon::create($currentYear,$currentMonth,$currentDay,16,30,00,'Asia/Yangon');
        $rewards = [];
        $referrals = [];
    
        // if ( $now == 'Friday' || $current->gt($even) )
        if ( $date )
        {
            $users = NormalUser::all();
            foreach($users as $user)
            {
                $result = BetSlip::where('userId',$user->id)->whereBetween('forDate',[$start,$end])->where('type','D2D')->where('reward','=','0')->sum('bet_slips.total-bet-amount');
                if (!BetSlip::whereBetween('forDate',[$start,$end])->where('type','D2D')->where('reward','=','0')->first())
                {
                    $rewards = [];
                    $referrals = [];   
                }
                if(BetSlip::where('userId',$user->id)->whereBetween('forDate',[$start,$end])->first())
                {   
                    $ref = Referrals::where('submitted-userId',$user->id)->first();

                    if(Referrals::where('submitted-userId',$user->id)->first())
                    {
                    $ref_user = NormalUser::where('referral-code',$ref['referral-code'])->first();

                        if( $ref_user['user-level'] == 'ruby' )
                    {
                        $referrals[] = [
                            'user' => $ref_user,
                            'rewardAmount' => $result * 0.07,
                            'amount' => $result
                        ];
                    }
                    elseif( $ref_user['user-level'] == 'jade' )
                    {
                        $referrals[] = [
                            'user' => $ref_user,
                            'rewardAmount' => $result * 0.05,
                            'amount' => $result
                        ];
                    }
                    elseif( $ref_user['user-level'] == 'diamond' )
                    {
                        $referrals[] = [
                            'user' => $ref_user,
                            'rewardAmount' => $result * 0.04,
                            'amount' => $result
                        ];
                    }
                    elseif( $ref_user['user-level'] == 'gold' )
                    {
                        $referrals[] = [
                            'user' => $ref_user,
                            'rewardAmount' => $result * 0.03,
                            'amount' => $result
                        ];
                    }
                    elseif( $ref_user['user-level'] == 'silver' )
                    {
                        $referrals[] = [
                            'user' => $ref_user,
                            'rewardAmount' => $result * 0.02,
                            'amount' => $result
                        ];
                    }
                    elseif ( $ref_user['user-level'] == 'free')
                    {
                        $referrals[] = [
                            'user' => $ref_user,
                            'rewardAmount' => $result * 0.01,
                            'amount' => $result
                        ];
                    }
                    }
                    

                    if( $user['user-level'] == 'ruby' )
                    {
                        $rewards[] = [
                            'user' => $user,
                            'rewardAmount' => $result * 0.07,
                            'amount' => $result
                        ];
                    }
                    elseif( $user['user-level'] == 'jade' )
                    {
                        $rewards[] = [
                            'user' => $user,
                            'rewardAmount' => $result * 0.05,
                            'amount' => $result
                        ];
                    }
                    elseif( $user['user-level'] == 'diamond' )
                    {
                        $rewards[] = [
                            'user' => $user,
                            'rewardAmount' => $result * 0.04,
                            'amount' => $result
                        ];
                    }
                    elseif( $user['user-level'] == 'gold' )
                    {
                        $rewards[] = [
                            'user' => $user,
                            'rewardAmount' => $result * 0.03,
                            'amount' => $result
                        ];
                    }
                    elseif( $user['user-level'] == 'silver' )
                    {
                        $rewards[] = [
                            'user' => $user,
                            'rewardAmount' => $result * 0.02,
                            'amount' => $result
                        ];
                    }
                    elseif ( $user['user-level'] == 'free')
                    {
                        $rewards[] = [
                            'user' => $user,
                            'rewardAmount' => $result * 0.01,
                            'amount' => $result
                        ];
                    }
                }
            }

            return view('admin.reward.index',[
                'rewards' => $rewards,
                'referrals' => $referrals,
                'start' => $start,
                'end' => $end

            ]);
        }
        return view('admin.reward.index',[
                'rewards' => $rewards,
                'referrals' => $referrals,
                'start' => $start,
                'end' => $end
            ]);
    }

    public function submit(Request $request)
    {   
        $currentDay = Carbon::now('Asia/Yangon')->format('d');
        $currentMonth = Carbon::now('Asia/Yangon')->format('m');
        $currentYear = Carbon::now('Asia/Yangon')->format('Y');

        $currentHour = Carbon::now('Asia/Yangon')->format('H');
        $currentMin = Carbon::now('Asia/Yangon')->format('i');
        $currentSec = Carbon::now('Asia/Yangon')->format('s');

        $date = Carbon::now('Asia/Yangon');
        $date->setISODate($currentYear,$date->weekOfYear);
        $start = $date->startOfWeek()->format('d.m.Y');
        $end = $date->endOfWeek()->format('d.m.Y');
        $now = Carbon::now('Asia/Yangon')->format('l');

        $current = Carbon::create($currentYear,$currentMonth,$currentDay,$currentHour,$currentMin,$currentSec,'Asia/Yangon');
        $even = Carbon::create($currentYear,$currentMonth,$currentDay,16,30,00,'Asia/Yangon');
        $rewards = [];
        $referrals = [];
    
        // if ( $now == 'Friday' || $current->gt($even) )
        if ( $date )
        {
            $users = NormalUser::all();
            foreach($users as $user)
            {   
                $result = BetSlip::where('userId',$user->id)->whereBetween('forDate',[$start,$end])->where('type','D2D')->where('reward','=','0')->sum('bet_slips.total-bet-amount');
                if (!BetSlip::whereBetween('forDate',[$start,$end])->where('type','D2D')->where('reward','=','0')->first())
                {
                    $rewards = [];
                    $referrals = [];

                    return back()->with('message','No Betslips. Not Available Yet!');
                }
                if(BetSlip::where('userId',$user->id)->whereBetween('forDate',[$start,$end])->first())
                {   


                    $ref = Referrals::where('submitted-userId',$user->id)->first();

                    if(Referrals::where('submitted-userId',$user->id)->first())
                    {
                    $ref_user = NormalUser::where('referral-code',$ref['referral-code'])->first();

                        if( $ref_user['user-level'] == 'ruby' )
                    {
                        $referrals[] = [
                            'user' => $ref_user,
                            'rewardAmount' => $result * 0.07,
                            'amount' => $result
                        ];

                        Rewards::insert([
                            'userId' => $ref_user->id,
                            'time' => $start.'to'.$end,
                            'amount' => $result * 0.07,
                            'receive_from' => $user->id,
                            'type' => 'referral'
                        ]);
                    }
                    elseif( $ref_user['user-level'] == 'jade' )
                    {
                        $referrals[] = [
                            'user' => $ref_user,
                            'rewardAmount' => $result * 0.05,
                            'amount' => $result
                        ];

                        Rewards::insert([
                            'userId' => $ref_user->id,
                            'time' => $start.'to'.$end,
                            'amount' => $result * 0.05,
                            'receive_from' => $user->id,
                            'type' => 'referral'
                        ]);
                    }
                    elseif( $ref_user['user-level'] == 'diamond' )
                    {
                        $referrals[] = [
                            'user' => $ref_user,
                            'rewardAmount' => $result * 0.04,
                            'amount' => $result
                        ];

                        Rewards::insert([
                            'userId' => $ref_user->id,
                            'time' => $start.'to'.$end,
                            'amount' => $result * 0.04,
                            'receive_from' => $user->id,
                            'type' => 'referral'
                        ]);
                    }
                    elseif( $ref_user['user-level'] == 'gold' )
                    {
                        $referrals[] = [
                            'user' => $ref_user,
                            'rewardAmount' => $result * 0.03,
                            'amount' => $result
                        ];
                        Rewards::insert([
                            'userId' => $ref_user->id,
                            'time' => $start.'to'.$end,
                            'amount' => $result * 0.03,
                            'receive_from' => $user->id,
                            'type' => 'referral'
                        ]);

                    }
                    elseif( $ref_user['user-level'] == 'silver' )
                    {
                        $referrals[] = [
                            'user' => $ref_user,
                            'rewardAmount' => $result * 0.02,
                            'amount' => $result
                        ];
                        Rewards::insert([
                            'userId' => $ref_user->id,
                            'time' => $start.'to'.$end,
                            'amount' => $result * 0.02,
                            'receive_from' => $user->id,
                            'type' => 'referral'
                        ]);
                    }
                    elseif ( $ref_user['user-level'] == 'free')
                    {
                        $referrals[] = [
                            'user' => $ref_user,
                            'rewardAmount' => $result * 0.01,
                            'amount' => $result
                        ];

                        Rewards::insert([
                            'userId' => $ref_user->id,
                            'time' => $start.'to'.$end,
                            'amount' => $result * 0.01,
                            'receive_from' => $user->id,
                            'type' => 'referral'
                        ]);
                    }
                    }
                    

                    if( $user['user-level'] == 'ruby' )
                    {
                        $rewards[] = [
                            'user' => $user,
                            'rewardAmount' => $result * 0.07,
                            'amount' => $result
                        ];

                        Rewards::insert([
                            'userId' => $user->id,
                            'amount' => $result * 0.07,
                            'time' => $start.'to'.$end,
                            'receive_from' => '-',
                            'type' => 'reward'
                        ]);
                    }
                    elseif( $user['user-level'] == 'jade' )
                    {
                        $rewards[] = [
                            'user' => $user,
                            'rewardAmount' => $result * 0.05,
                            'time' => $start.'to'.$end,
                            'amount' => $result
                        ];

                        Rewards::insert([
                            'userId' => $user->id,
                            'amount' => $result * 0.05,
                            'time' => $start.'to'.$end,
                            'receive_from' => '-',
                            'type' => 'reward'
                        ]);
                    }
                    elseif( $user['user-level'] == 'diamond' )
                    {
                        $rewards[] = [
                            'user' => $user,
                            'rewardAmount' => $result * 0.04,
                            'amount' => $result
                        ];

                        Rewards::insert([
                            'userId' => $user->id,
                            'amount' => $result * 0.04,
                            'time' => $start.'to'.$end,
                            'receive_from' => '-',
                            'type' => 'reward'
                        ]);
                    }
                    elseif( $user['user-level'] == 'gold' )
                    {
                        $rewards[] = [
                            'user' => $user,
                            'rewardAmount' => $result * 0.03,
                            'amount' => $result
                        ];

                        Rewards::insert([
                            'userId' => $user->id,
                            'amount' => $result * 0.03,
                            'time' => $start.'to'.$end,
                            'receive_from' => '-',
                            'type' => 'reward'
                        ]);
                    }
                    elseif( $user['user-level'] == 'silver' )
                    {
                        $rewards[] = [
                            'user' => $user,
                            'rewardAmount' => $result * 0.02,
                            'amount' => $result
                        ];

                        Rewards::insert([
                            'userId' => $user->id,
                            'amount' => $result * 0.02,
                            'time' => $start.'to'.$end,
                            'receive_from' => '-',
                            'type' => 'reward'
                        ]);
                    }
                    elseif ( user['user-level'] == 'free')
                    {
                        $rewards[] = [
                            'user' => $user,
                            'rewardAmount' => $result * 0.01,
                            'amount' => $result
                        ];

                        Rewards::insert([
                            'userId' => $user->id,
                            'amount' => $result * 0.01,
                            'time' => $start.'to'.$end,
                            'receive_from' => '-',
                            'type' => 'reward'
                        ]);
                    }

                    $update = BetSlip::where('userId',$user->id)->whereBetween('forDate',[$start,$end])->where('type','D2D')->where('reward','=','0')->get();

                    $update->update([ 'referral' => '1', 'reward' => '0' ]);
                }
            }

            return back()->with('message','Rewarded Successfully');
        }
        
        return back()->with('message','Not Available Yet!');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
