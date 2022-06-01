<?php

namespace App\Http\Controllers;
use App\Models\DthreeD;
use App\Models\Internet;
use App\Models\BetSlip;
use App\Models\BetInteger;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $currentDay = Carbon::now('Asia/Yangon')->format('d');
        $currentMonth = Carbon::now('Asia/Yangon')->format('m');
        $currentYear = Carbon::now('Asia/Yangon')->format('Y');
        $noon = Carbon::create($currentYear,$currentMonth,$currentDay,12,01,00,'Asia/Yangon');
        $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        $day = Carbon::now('Asia/Yangon')->format('l');
        $tdate = Carbon::tomorrow('Asia/Yangon')->format('d.m.Y');
        $tday = Carbon::tomorrow('Asia/Yangon')->format('l');
        $time =  Carbon::now('Asia/Yangon');
        $winNumberNoon = DthreeD::where('date',$date)->where('time','12:01 PM')->value('3D');
        $winNumberEven = DthreeD::where('date',$date)->where('time','4:31 PM')->value('3D');
        $NoonSlipsAmount = 0;
        $NoonSlipsAmount = BetSlip::where('forDate',$date)->where('forTime','12:01 PM')->where('type','D2D')->sum('bet_slips.total-bet-amount');
        $NoonSlipsAmount15 = $NoonSlipsAmount * 0.15;

        $EvenSlipsAmount = 0;
        $EvenSlipsAmount = BetSlip::where('forDate',$date)->where('forTime','4:30 PM')->where('type','D2D')->sum('bet_slips.total-bet-amount');
        $EvenSlipsAmount15 = $EvenSlipsAmount * 0.15;
        
        $tmrNoonSlipsAmount = 0;
        $tmrNoonSlipsAmount = BetSlip::where('forDate',$tdate)->where('forTime','12:01 PM')->where('type','D2D')->sum('bet_slips.total-bet-amount');
        $tmrNoonSlipsAmount15 = $tmrNoonSlipsAmount * 0.15;
        
        
        $tmrEvenSlipsAmount = 0;
        $tmrEvenSlipsAmount = BetSlip::where('forDate',$tdate)->where('forTime','4:30 PM')->where('type','D2D')->sum('bet_slips.total-bet-amount');
        $tmrEvenSlipsAmount15 = $tmrEvenSlipsAmount * 0.15;
        
        
        $totalPayout = 0;
        $totalWinAmount = 0;
        $totalEvenPayout = 0;
        $totalEvenWinAmount = 0;
        $totalTmrPayout = 0;
        $totalTmrEvenPayout = 0;

        if (!(empty($winNumberNoon)) )
        {
            // $NoonBets = BetInteger::join('bet_slips', function ($join) {

            //     $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
            //     $winNumberNoon = DthreeD::where('date',$date)->where('time','12:01 PM')->value('3D');
            //                         $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
            //                              ->where('bet_slips.forDate', '=',$date)
            //                              ->where('bet_slips.forTime','=','12:01 PM')
            //                              ->where('bet_integers.integer','=',$winNumberNoon);
            //                     })
            //                     ->get();
                $NoonBetsTwod = BetInteger::join('bet_slips', function ($join) {

                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                $winNumberNoon = DthreeD::where('date',$date)->where('time','12:01 PM')->value('3D');
                                    $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                         ->where('bet_slips.forDate', '=',$date)
                                         ->where('bet_slips.type','=','D2D')
                                         ->where('bet_slips.forTime','=','12:01 PM')
                                         ->where('bet_integers.integer','=',$winNumberNoon[1].$winNumberNoon[2]);
                                })
                                ->get();

                // $NoonBetsRound = BetInteger::join('bet_slips', function ($join) {

                // $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                //                     $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                //                          ->where('bet_slips.forDate', '=',$date)
                //                          ->where('bet_slips.forTime','=','12:01 PM')
                //                          ->where(function($query){
                // $date = Carbon::now('Asia/Yangon')->format('d.m.Y');

                // $winNumberNoon = DthreeD::where('date',$date)->where('time','12:01 PM')->value('3D');
                
                                            
                //                             $query->where('bet_integers.integer','=',$winNumberNoon + 1);
                //                             $query->orWhere('bet_integers.integer','=',$winNumberNoon - 1);
                //                             $query->orWhere('bet_integers.integer','=',$winNumberNoon[0].$winNumberNoon[2].$winNumberNoon[1]);
                //                             $query->orWhere('bet_integers.integer','=',$winNumberNoon[1].$winNumberNoon[2].$winNumberNoon[0]);
                //                             $query->orWhere('bet_integers.integer','=',$winNumberNoon[1].$winNumberNoon[0].$winNumberNoon[2]);
                //                             $query->orWhere('bet_integers.integer','=',$winNumberNoon[2].$winNumberNoon[0].$winNumberNoon[1]);
                //                             $query->orWhere('bet_integers.integer','=',$winNumberNoon[2].$winNumberNoon[1].$winNumberNoon[0]);

                //                         });
                //                 })
                //                 ->get();
                // if ( $NoonBets )
                // {
                //     foreach ($NoonBets as $NoonBet)
                //     {
                //         $totalPayout += $NoonBet['amount'] * 600;
                //         $totalWinAmount += $NoonBet['amount'];
                //     }
                // }

                if ( $NoonBetsTwod )

                {
                    foreach ($NoonBetsTwod as $NoonBetTwod)
                    {
                        $totalPayout += $NoonBetTwod['amount'] * 80;
                        $totalWinAmount += $NoonBetTwod['amount'];
                    }
                }

                // if ( $NoonBetsRound )

                // {
                //     foreach ($NoonBetsRound as $NoonBetRound)
                //     {
                //         $totalPayout += $NoonBetRound['amount'] * 10;
                //         $totalWinAmount += $NoonBetRound['amount'];
                //     }
                // }
        }

        if (!(empty($winNumberEven)))
        {
            // $EvenBets = BetInteger::join('bet_slips', function ($join) {

            //     $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
            //     $winNumberEven = DthreeD::where('date',$date)->where('time','4:31 PM')->value('3D');
            //                         $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
            //                              ->where('bet_slips.forDate', '=',$date)
            //                              ->where('bet_slips.forTime','=','4:30 PM')
            //                              ->where('bet_integers.integer','=',$winNumberEven);
            //                     })
            //                     ->get();

                $EvenBetsTwod = BetInteger::join('bet_slips', function ($join) {

                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                $winNumberEven = DthreeD::where('date',$date)->where('time','4:31 PM')->value('3D');
                                    $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                         ->where('bet_slips.forDate', '=',$date)
                                         ->where('bet_slips.type','=','D2D')
                                         ->where('bet_slips.forTime','=','4:30 PM')
                                         ->where('bet_integers.integer','=',$winNumberEven[1].$winNumberEven[2]);
                                })
                                ->get();

                // $EvenBetsRound = BetInteger::join('bet_slips', function ($join) {

                // $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                //                     $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                //                          ->where('bet_slips.forDate', '=',$date)
                //                          ->where('bet_slips.forTime','=','4:30 PM')
                //                          ->where(function($query){
                // $date = Carbon::now('Asia/Yangon')->format('d.m.Y');

                // $winNumberEven = DthreeD::where('date',$date)->where('time','4:31 PM')->value('3D');
                
                                            
                //                             $query->where('bet_integers.integer','=',$winNumberEven + 1);
                //                             $query->orWhere('bet_integers.integer','=',$winNumberEven - 1);
                //                             $query->orWhere('bet_integers.integer','=',$winNumberEven[0].$winNumberEven[2].$winNumberEven[1]);
                //                             $query->orWhere('bet_integers.integer','=',$winNumberEven[1].$winNumberEven[2].$winNumberEven[0]);
                //                             $query->orWhere('bet_integers.integer','=',$winNumberEven[1].$winNumberEven[0].$winNumberEven[2]);
                //                             $query->orWhere('bet_integers.integer','=',$winNumberEven[2].$winNumberEven[0].$winNumberEven[1]);
                //                             $query->orWhere('bet_integers.integer','=',$winNumberEven[2].$winNumberEven[1].$winNumberEven[0]);

                //                         });
                //                 })
                //                 ->get();
                // if ( $EvenBets )
                // {
                //     foreach ($EvenBets as $EvenBet)
                //     {
                //         $totalEvenPayout += $EvenBet['amount'] * 600;
                //         $totalEvenWinAmount += $EvenBet['amount'];
                //     }
                // }

                if ( $EvenBetsTwod )

                {
                    foreach ($EvenBetsTwod as $EvenBetTwod)
                    {
                        $totalEvenPayout += $EvenBetTwod['amount'] * 80;
                        $totalEvenWinAmount += $EvenBetTwod['amount'];

                    }
                }

                // if ( $EvenBetsRound )

                // {
                //     foreach ($EvenBetsRound as $EvenBetRound)
                //     {
                //         $totalEvenPayout += $EvenBetRound['amount'] * 10;
                //         $totalEvenWinAmount += $EvenBetRound['amount'];

                //     }
                // }

        }
        
        
        

        

        // if (BetSlip::where('forDate',$date)->where('status','ongoing')->where('forTime','12:01 PM')->first())
        // {   
            
        //     $NoonSlipsAmount = BetSlip::where('forDate',$date)->where('forTime','12:01 PM')->sum('bet_slips.total-bet-amount');
        //     $PayoutNoonThreeD = BetInteger::whereIn('bet-slip-id',[$NoonSlips->id])->where('integer',$winNumberNoon)->sum('bet_integers.amount');
        //     $PayoutNoonTwoD = BetInteger::whereIn('bet-slip-id',[$NoonSlips->id])->where('integer',$winNumberNoon[1].$winNumberNoon[2])->sum('bet_integers.amount');
        //     $PayoutNoonRound = BetInteger::whereIn('bet-slip-id',[$NoonSlips->id])
        //                                 ->where('integer',$winNumberNoon + 1)
        //                                 ->orWhere('integer',$winNumberNoon - 1)
        //                                 ->orWhere('integer',$winNumberNoon[1].$winNumberNoon[2].$winNumberNoon[0])
        //                                 ->orWhere('integer',$winNumberNoon[1].$winNumberNoon[0].$winNumberNoon[2])
        //                                 ->orWhere('integer',$winNumberNoon[2].$winNumberNoon[0].$winNumberNoon[1])
        //                                 ->orWhere('integer',$winNumberNoon[2].$winNumberNoon[1].$winNumberNoon[0])
        //                                 ->orWhere('integer',$winNumberNoon[0].$winNumberNoon[2].$winNumberNoon[1])
        //                                 ->sum('bet_integers.amount');
            
        //     $totalPayout = $PayoutNoonRound + $PayoutNoonThreeD + $PayoutNoonTwoD;
        // }

        
        return view('home',[
            'winNumberNoon' => $winNumberNoon,
            'winNumberEven' => $winNumberEven,
            'payout' => $totalPayout,
            'evenPayout' => $totalEvenPayout,
            'winAmount' => $totalWinAmount,
            'winEvenAmount' => $totalEvenWinAmount,
            'tmrPayout' => $totalTmrPayout,
            'tmrEvenPayout' => $totalTmrEvenPayout,
            'NoonSlipAmount' => $NoonSlipsAmount,
            'EvenSlipAmount' => $EvenSlipsAmount,
            'tmrNoonSlipAmount' => $tmrNoonSlipsAmount,
            'tmrEvenSlipAmount' => $tmrEvenSlipsAmount,
            'NetProfit' => $NoonSlipsAmount - ( $totalPayout + $NoonSlipsAmount15 ),
            'EvenNetProfit' => $EvenSlipsAmount  - ( $totalEvenPayout + $EvenSlipsAmount15 ),
            'TmrNetProfit' => $tmrNoonSlipsAmount - ( $totalTmrPayout + $tmrNoonSlipsAmount15 ),
            'TmrEvenNetProfit' => $tmrEvenSlipsAmount - ( $totalTmrEvenPayout + $tmrEvenSlipsAmount15 ),
            'date' => $date,
            'day' => $day,
            'tdate' => $tdate,
            'tday' => $tday
        ]);


    }
    
    public function indexThreeD()
    {   
        $currentDay = Carbon::now('Asia/Yangon')->format('d');
        $currentMonth = Carbon::now('Asia/Yangon')->format('m');
        $currentYear = Carbon::now('Asia/Yangon')->format('Y');
        $noon = Carbon::create($currentYear,$currentMonth,$currentDay,12,01,00,'Asia/Yangon');
        $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        $day = Carbon::now('Asia/Yangon')->format('l');
        $tdate = Carbon::tomorrow('Asia/Yangon')->format('d.m.Y');
        $tday = Carbon::tomorrow('Asia/Yangon')->format('l');
        $time =  Carbon::now('Asia/Yangon');
        $winNumberNoon = DthreeD::where('date',$date)->where('time','12:01 PM')->value('3D');
        $winNumberEven = DthreeD::where('date',$date)->where('time','4:31 PM')->value('3D');
        $NoonSlipsAmount = 0;
        $NoonSlipsAmount = BetSlip::where('forDate',$date)->where('forTime','12:01 PM')->whereIn('type',['D3D'])->sum('bet_slips.total-bet-amount');
        $NoonSlipsAmount15 = $NoonSlipsAmount * 0.15;

        $EvenSlipsAmount = 0;
        $EvenSlipsAmount = BetSlip::where('forDate',$date)->where('forTime','4:30 PM')->whereIn('type',['D3D'])->sum('bet_slips.total-bet-amount');
        $EvenSlipsAmount15 = $EvenSlipsAmount * 0.15;
        
        $tmrNoonSlipsAmount = 0;
        $tmrNoonSlipsAmount = BetSlip::where('forDate',$tdate)->where('forTime','12:01 PM')->whereIn('type',['D3D'])->sum('bet_slips.total-bet-amount');
        $tmrNoonSlipsAmount15 = $tmrNoonSlipsAmount * 0.15;
        
        
        $tmrEvenSlipsAmount = 0;
        $tmrEvenSlipsAmount = BetSlip::where('forDate',$tdate)->where('forTime','4:30 PM')->whereIn('type',['D3D'])->sum('bet_slips.total-bet-amount');
        $tmrEvenSlipsAmount15 = $tmrEvenSlipsAmount * 0.15;
        
        
        $totalPayout = 0;
        $totalWinAmount = 0;
        $totalEvenPayout = 0;
        $totalEvenWinAmount = 0;
        $totalTmrPayout = 0;
        $totalTmrEvenPayout = 0;

        if (!(empty($winNumberNoon)) )
        {
            $NoonBets = BetInteger::join('bet_slips', function ($join) {

                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                $winNumberNoon = DthreeD::where('date',$date)->where('time','12:01 PM')->value('3D');
                                    $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                         ->where('bet_slips.forDate', '=',$date)
                                         ->where('bet_slips.type','=','D3D')
                                         ->where('bet_slips.forTime','=','12:01 PM')
                                         ->where('bet_integers.integer','=',$winNumberNoon);
                                })
                                ->get();
                

                $NoonBetsRound = BetInteger::join('bet_slips', function ($join) {

                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                                    $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                         ->where('bet_slips.forDate', '=',$date)
                                         ->where('bet_slips.type','=','D3D')
                                         ->where('bet_slips.forTime','=','12:01 PM')
                                         ->where(function($query){
                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');

                $winNumberNoon = DthreeD::where('date',$date)->where('time','12:01 PM')->value('3D');
                
                                            
                                            $query->where('bet_integers.integer','=',$winNumberNoon + 1);
                                            $query->orWhere('bet_integers.integer','=',$winNumberNoon - 1);
                                            $query->orWhere('bet_integers.integer','=',$winNumberNoon[0].$winNumberNoon[2].$winNumberNoon[1]);
                                            $query->orWhere('bet_integers.integer','=',$winNumberNoon[1].$winNumberNoon[2].$winNumberNoon[0]);
                                            $query->orWhere('bet_integers.integer','=',$winNumberNoon[1].$winNumberNoon[0].$winNumberNoon[2]);
                                            $query->orWhere('bet_integers.integer','=',$winNumberNoon[2].$winNumberNoon[0].$winNumberNoon[1]);
                                            $query->orWhere('bet_integers.integer','=',$winNumberNoon[2].$winNumberNoon[1].$winNumberNoon[0]);

                                        });
                                })
                                ->get();
                if ( $NoonBets )
                {
                    foreach ($NoonBets as $NoonBet)
                    {
                        $totalPayout += $NoonBet['amount'] * 600;
                        $totalWinAmount += $NoonBet['amount'];
                    }
                }

                if ( $NoonBetsRound )

                {
                    foreach ($NoonBetsRound as $NoonBetRound)
                    {
                        $totalPayout += $NoonBetRound['amount'] * 10;
                        $totalWinAmount += $NoonBetRound['amount'];
                    }
                }
        }

        if (!(empty($winNumberEven)))
        {
            $EvenBets = BetInteger::join('bet_slips', function ($join) {

                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                $winNumberEven = DthreeD::where('date',$date)->where('time','4:31 PM')->value('3D');
                                    $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                         ->where('bet_slips.forDate', '=',$date)
                                         ->where('bet_slips.type','=','D3D')
                                         ->where('bet_slips.forTime','=','4:30 PM')
                                         ->where('bet_integers.integer','=',$winNumberEven);
                                })
                                ->get();

                $EvenBetsRound = BetInteger::join('bet_slips', function ($join) {

                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                                    $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                         ->where('bet_slips.forDate', '=',$date)
                                         ->where('bet_slips.type','=','D3D')
                                         ->where('bet_slips.forTime','=','4:30 PM')
                                         ->where(function($query){
                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');

                $winNumberEven = DthreeD::where('date',$date)->where('time','4:31 PM')->value('3D');
                
                                            
                                            $query->where('bet_integers.integer','=',$winNumberEven + 1);
                                            $query->orWhere('bet_integers.integer','=',$winNumberEven - 1);
                                            $query->orWhere('bet_integers.integer','=',$winNumberEven[0].$winNumberEven[2].$winNumberEven[1]);
                                            $query->orWhere('bet_integers.integer','=',$winNumberEven[1].$winNumberEven[2].$winNumberEven[0]);
                                            $query->orWhere('bet_integers.integer','=',$winNumberEven[1].$winNumberEven[0].$winNumberEven[2]);
                                            $query->orWhere('bet_integers.integer','=',$winNumberEven[2].$winNumberEven[0].$winNumberEven[1]);
                                            $query->orWhere('bet_integers.integer','=',$winNumberEven[2].$winNumberEven[1].$winNumberEven[0]);

                                        });
                                })
                                ->get();
                if ( $EvenBets )
                {
                    foreach ($EvenBets as $EvenBet)
                    {
                        $totalEvenPayout += $EvenBet['amount'] * 600;
                        $totalEvenWinAmount += $EvenBet['amount'];
                    }
                }

                if ( $EvenBetsRound )

                {
                    foreach ($EvenBetsRound as $EvenBetRound)
                    {
                        $totalEvenPayout += $EvenBetRound['amount'] * 10;
                        $totalEvenWinAmount += $EvenBetRound['amount'];

                    }
                }

        }
        
        
        

        

        // if (BetSlip::where('forDate',$date)->where('status','ongoing')->where('forTime','12:01 PM')->first())
        // {   
            
        //     $NoonSlipsAmount = BetSlip::where('forDate',$date)->where('forTime','12:01 PM')->sum('bet_slips.total-bet-amount');
        //     $PayoutNoonThreeD = BetInteger::whereIn('bet-slip-id',[$NoonSlips->id])->where('integer',$winNumberNoon)->sum('bet_integers.amount');
        //     $PayoutNoonTwoD = BetInteger::whereIn('bet-slip-id',[$NoonSlips->id])->where('integer',$winNumberNoon[1].$winNumberNoon[2])->sum('bet_integers.amount');
        //     $PayoutNoonRound = BetInteger::whereIn('bet-slip-id',[$NoonSlips->id])
        //                                 ->where('integer',$winNumberNoon + 1)
        //                                 ->orWhere('integer',$winNumberNoon - 1)
        //                                 ->orWhere('integer',$winNumberNoon[1].$winNumberNoon[2].$winNumberNoon[0])
        //                                 ->orWhere('integer',$winNumberNoon[1].$winNumberNoon[0].$winNumberNoon[2])
        //                                 ->orWhere('integer',$winNumberNoon[2].$winNumberNoon[0].$winNumberNoon[1])
        //                                 ->orWhere('integer',$winNumberNoon[2].$winNumberNoon[1].$winNumberNoon[0])
        //                                 ->orWhere('integer',$winNumberNoon[0].$winNumberNoon[2].$winNumberNoon[1])
        //                                 ->sum('bet_integers.amount');
            
        //     $totalPayout = $PayoutNoonRound + $PayoutNoonThreeD + $PayoutNoonTwoD;
        // }

        
        return view('betdetail.threed',[
            'winNumberNoon' => $winNumberNoon,
            'winNumberEven' => $winNumberEven,
            'payout' => $totalPayout,
            'evenPayout' => $totalEvenPayout,
            'winAmount' => $totalWinAmount,
            'winEvenAmount' => $totalEvenWinAmount,
            'tmrPayout' => $totalTmrPayout,
            'tmrEvenPayout' => $totalTmrEvenPayout,
            'NoonSlipAmount' => $NoonSlipsAmount,
            'EvenSlipAmount' => $EvenSlipsAmount,
            'tmrNoonSlipAmount' => $tmrNoonSlipsAmount,
            'tmrEvenSlipAmount' => $tmrEvenSlipsAmount,
            'NetProfit' => $NoonSlipsAmount - ( $totalPayout + $NoonSlipsAmount15 ),
            'EvenNetProfit' => $EvenSlipsAmount  - ( $totalEvenPayout + $EvenSlipsAmount15 ),
            'TmrNetProfit' => $tmrNoonSlipsAmount - ( $totalTmrPayout + $tmrNoonSlipsAmount15 ),
            'TmrEvenNetProfit' => $tmrEvenSlipsAmount - ( $totalTmrEvenPayout + $tmrEvenSlipsAmount15 ),
            'date' => $date,
            'day' => $day,
            'tdate' => $tdate,
            'tday' => $tday
        ]);


    }

    public function indexTwodPlus()
    {   
        $currentDay = Carbon::now('Asia/Yangon')->format('d');
        $currentMonth = Carbon::now('Asia/Yangon')->format('m');
        $currentYear = Carbon::now('Asia/Yangon')->format('Y');
        $noon = Carbon::create($currentYear,$currentMonth,$currentDay,12,01,00,'Asia/Yangon');
        $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        $day = Carbon::now('Asia/Yangon')->format('l');
        $tdate = Carbon::tomorrow('Asia/Yangon')->format('d.m.Y');
        $tday = Carbon::tomorrow('Asia/Yangon')->format('l');
        $time =  Carbon::now('Asia/Yangon');
        $winNumberNoon = DthreeD::where('date',$date)->where('time','12:01 PM')->value('plustwod');
        $winNumberEven = DthreeD::where('date',$date)->where('time','4:31 PM')->value('plustwod');
        $NoonSlipsAmount = 0;
        $NoonSlipsAmount = BetSlip::where('forDate',$date)->where('forTime','12:01 PM')->where('type','2DPLUS')->sum('bet_slips.total-bet-amount');
        $NoonSlipsAmount15 = $NoonSlipsAmount * 0.10;

        $EvenSlipsAmount = 0;
        $EvenSlipsAmount = BetSlip::where('forDate',$date)->where('forTime','4:30 PM')->where('type','2DPLUS')->sum('bet_slips.total-bet-amount');
        $EvenSlipsAmount15 = $EvenSlipsAmount * 0.10;
        
        $tmrNoonSlipsAmount = 0;
        $tmrNoonSlipsAmount = BetSlip::where('forDate',$tdate)->where('forTime','12:01 PM')->where('type','2DPLUS')->sum('bet_slips.total-bet-amount');
        $tmrNoonSlipsAmount15 = $tmrNoonSlipsAmount * 0.10;
        
        
        $tmrEvenSlipsAmount = 0;
        $tmrEvenSlipsAmount = BetSlip::where('forDate',$tdate)->where('forTime','4:30 PM')->where('type','2DPLUS')->sum('bet_slips.total-bet-amount');
        $tmrEvenSlipsAmount15 = $tmrEvenSlipsAmount * 0.10;
        
        
        $totalPayout = 0;
        $totalWinAmount = 0;
        $totalEvenPayout = 0;
        $totalEvenWinAmount = 0;
        $totalTmrPayout = 0;
        $totalTmrEvenPayout = 0;

        if (!(empty($winNumberNoon)) )
        {
            $NoonBets = BetInteger::join('bet_slips', function ($join) {

                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                $winNumberNoon = DthreeD::where('date',$date)->where('time','12:01 PM')->value('plustwod');
                                    $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                         ->where('bet_slips.forDate', '=',$date)
                                         ->where('bet_slips.forTime','=','12:01 PM')
                                         ->where('bet_slips.type', '=','2DPLUS')
                                         ->where('bet_integers.integer','=',$winNumberNoon);
                                })
                                ->get();
                if ( $NoonBets )
                {
                    foreach ($NoonBets as $NoonBet)
                    {
                        $totalPayout += $NoonBet['amount'] * 85;
                        $totalWinAmount += $NoonBet['amount'];
                    }
                }

        }

        if (!(empty($winNumberEven)))
        {
            $EvenBets = BetInteger::join('bet_slips', function ($join) {

                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                $winNumberEven = DthreeD::where('date',$date)->where('time','4:31 PM')->value('plustwod');
                                    $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                         ->where('bet_slips.forDate', '=',$date)
                                         ->where('bet_slips.forTime','=','4:30 PM')
                                         ->where('bet_slips.type', '=','2DPLUS')
                                         ->where('bet_integers.integer','=',$winNumberEven);
                                })
                                ->get();

                if ( $EvenBets )
                {
                    foreach ($EvenBets as $EvenBet)
                    {
                        $totalEvenPayout += $EvenBet['amount'] * 85;
                        $totalEvenWinAmount += $EvenBet['amount'];
                    }
                }
        }

        // if (BetSlip::where('forDate',$date)->where('status','ongoing')->where('forTime','12:01 PM')->first())
        // {   
            
        //     $NoonSlipsAmount = BetSlip::where('forDate',$date)->where('forTime','12:01 PM')->sum('bet_slips.total-bet-amount');
        //     $PayoutNoonThreeD = BetInteger::whereIn('bet-slip-id',[$NoonSlips->id])->where('integer',$winNumberNoon)->sum('bet_integers.amount');
        //     $PayoutNoonTwoD = BetInteger::whereIn('bet-slip-id',[$NoonSlips->id])->where('integer',$winNumberNoon[1].$winNumberNoon[2])->sum('bet_integers.amount');
        //     $PayoutNoonRound = BetInteger::whereIn('bet-slip-id',[$NoonSlips->id])
        //                                 ->where('integer',$winNumberNoon + 1)
        //                                 ->orWhere('integer',$winNumberNoon - 1)
        //                                 ->orWhere('integer',$winNumberNoon[1].$winNumberNoon[2].$winNumberNoon[0])
        //                                 ->orWhere('integer',$winNumberNoon[1].$winNumberNoon[0].$winNumberNoon[2])
        //                                 ->orWhere('integer',$winNumberNoon[2].$winNumberNoon[0].$winNumberNoon[1])
        //                                 ->orWhere('integer',$winNumberNoon[2].$winNumberNoon[1].$winNumberNoon[0])
        //                                 ->orWhere('integer',$winNumberNoon[0].$winNumberNoon[2].$winNumberNoon[1])
        //                                 ->sum('bet_integers.amount');
            
        //     $totalPayout = $PayoutNoonRound + $PayoutNoonThreeD + $PayoutNoonTwoD;
        // }

        
        return view('betdetail.twodplus',[
            'winNumberNoon' => $winNumberNoon,
            'winNumberEven' => $winNumberEven,
            'payout' => $totalPayout,
            'evenPayout' => $totalEvenPayout,
            'winAmount' => $totalWinAmount,
            'winEvenAmount' => $totalEvenWinAmount,
            'tmrPayout' => $totalTmrPayout,
            'tmrEvenPayout' => $totalTmrEvenPayout,
            'NoonSlipAmount' => $NoonSlipsAmount,
            'EvenSlipAmount' => $EvenSlipsAmount,
            'tmrNoonSlipAmount' => $tmrNoonSlipsAmount,
            'tmrEvenSlipAmount' => $tmrEvenSlipsAmount,
            'NetProfit' => $NoonSlipsAmount - ( $totalPayout + $NoonSlipsAmount15 ),
            'EvenNetProfit' => $EvenSlipsAmount  - ( $totalEvenPayout + $EvenSlipsAmount15 ),
            'TmrNetProfit' => $tmrNoonSlipsAmount - ( $totalTmrPayout + $tmrNoonSlipsAmount15 ),
            'TmrEvenNetProfit' => $tmrEvenSlipsAmount - ( $totalTmrEvenPayout + $tmrEvenSlipsAmount15 ),
            'date' => $date,
            'day' => $day,
            'tdate' => $tdate,
            'tday' => $tday
        ]);
    }

    public function indexInternet()
    {   
        $currentDay = Carbon::now('Asia/Yangon')->format('d');
        $currentMonth = Carbon::now('Asia/Yangon')->format('m');
        $currentYear = Carbon::now('Asia/Yangon')->format('Y');
        $noon = Carbon::create($currentYear,$currentMonth,$currentDay,9,31,00,'Asia/Yangon');
        $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        $day = Carbon::now('Asia/Yangon')->format('l');
        $tdate = Carbon::tomorrow('Asia/Yangon')->format('d.m.Y');
        $tday = Carbon::tomorrow('Asia/Yangon')->format('l');
        $time =  Carbon::now('Asia/Yangon');
        $winNumberNoon = Internet::where('date',$date)->where('time','9:30 AM')->value('internet');
        $winNumberEven = Internet::where('date',$date)->where('time','4:31 PM')->value('internet');
        $NoonSlipsAmount = 0;
        $NoonSlipsAmount = BetSlip::where('forDate',$date)->where('forTime','09:30 AM')->where('type','INTERNET')->sum('bet_slips.total-bet-amount');
        $NoonSlipsAmount15 = $NoonSlipsAmount * 0.15;

        $EvenSlipsAmount = 0;
        $EvenSlipsAmount = BetSlip::where('forDate',$date)->where('forTime','2:00 PM')->where('type','INTERNET')->sum('bet_slips.total-bet-amount');
        $EvenSlipsAmount15 = $EvenSlipsAmount * 0.15;
        
        $tmrNoonSlipsAmount = 0;
        $tmrNoonSlipsAmount = BetSlip::where('forDate',$tdate)->where('forTime','09:30 AM')->where('type','INTERNET')->sum('bet_slips.total-bet-amount');
        $tmrNoonSlipsAmount15 = $tmrNoonSlipsAmount * 0.15;
        
        
        $tmrEvenSlipsAmount = 0;
        $tmrEvenSlipsAmount = BetSlip::where('forDate',$tdate)->where('forTime','2:00 PM')->where('type','INTERNET')->sum('bet_slips.total-bet-amount');
        $tmrEvenSlipsAmount15 = $tmrEvenSlipsAmount * 0.15;
        
        
        $totalPayout = 0;
        $totalWinAmount = 0;
        $totalEvenPayout = 0;
        $totalEvenWinAmount = 0;
        $totalTmrPayout = 0;
        $totalTmrEvenPayout = 0;

        if (!(empty($winNumberNoon)) )
        {
            $NoonBets = BetInteger::join('bet_slips', function ($join) {

                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                $winNumberNoon = Internet::where('date',$date)->where('time','9:30 AM')->value('internet');
                                    $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                         ->where('bet_slips.forDate', '=',$date)
                                         ->where('bet_slips.forTime','=','9:30 AM')
                                         ->where('bet_slips.type', '=','INTERNET')
                                         ->where('bet_integers.integer','=',$winNumberNoon);
                                })
                                ->get();
                if ( $NoonBets )
                {
                    foreach ($NoonBets as $NoonBet)
                    {
                        $totalPayout += $NoonBet['amount'] * 80;
                        $totalWinAmount += $NoonBet['amount'];
                    }
                }

        }

        if (!(empty($winNumberEven)))
        {
            $EvenBets = BetInteger::join('bet_slips', function ($join) {

                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                $winNumberEven = Internet::where('date',$date)->where('time','2:00 PM')->value('internet');
                                    $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                         ->where('bet_slips.forDate', '=',$date)
                                         ->where('bet_slips.forTime','=','2:00 PM')
                                         ->where('bet_slips.type', '=','INTERNET')
                                         ->where('bet_integers.integer','=',$winNumberEven);
                                })
                                ->get();

                if ( $EvenBets )
                {
                    foreach ($EvenBets as $EvenBet)
                    {
                        $totalEvenPayout += $EvenBet['amount'] * 80;
                        $totalEvenWinAmount += $EvenBet['amount'];
                    }
                }
        }

        // if (BetSlip::where('forDate',$date)->where('status','ongoing')->where('forTime','12:01 PM')->first())
        // {   
            
        //     $NoonSlipsAmount = BetSlip::where('forDate',$date)->where('forTime','12:01 PM')->sum('bet_slips.total-bet-amount');
        //     $PayoutNoonThreeD = BetInteger::whereIn('bet-slip-id',[$NoonSlips->id])->where('integer',$winNumberNoon)->sum('bet_integers.amount');
        //     $PayoutNoonTwoD = BetInteger::whereIn('bet-slip-id',[$NoonSlips->id])->where('integer',$winNumberNoon[1].$winNumberNoon[2])->sum('bet_integers.amount');
        //     $PayoutNoonRound = BetInteger::whereIn('bet-slip-id',[$NoonSlips->id])
        //                                 ->where('integer',$winNumberNoon + 1)
        //                                 ->orWhere('integer',$winNumberNoon - 1)
        //                                 ->orWhere('integer',$winNumberNoon[1].$winNumberNoon[2].$winNumberNoon[0])
        //                                 ->orWhere('integer',$winNumberNoon[1].$winNumberNoon[0].$winNumberNoon[2])
        //                                 ->orWhere('integer',$winNumberNoon[2].$winNumberNoon[0].$winNumberNoon[1])
        //                                 ->orWhere('integer',$winNumberNoon[2].$winNumberNoon[1].$winNumberNoon[0])
        //                                 ->orWhere('integer',$winNumberNoon[0].$winNumberNoon[2].$winNumberNoon[1])
        //                                 ->sum('bet_integers.amount');
            
        //     $totalPayout = $PayoutNoonRound + $PayoutNoonThreeD + $PayoutNoonTwoD;
        // }

        
        return view('betdetail.internet',[
            'winNumberNoon' => $winNumberNoon,
            'winNumberEven' => $winNumberEven,
            'payout' => $totalPayout,
            'evenPayout' => $totalEvenPayout,
            'winAmount' => $totalWinAmount,
            'winEvenAmount' => $totalEvenWinAmount,
            'tmrPayout' => $totalTmrPayout,
            'tmrEvenPayout' => $totalTmrEvenPayout,
            'NoonSlipAmount' => $NoonSlipsAmount,
            'EvenSlipAmount' => $EvenSlipsAmount,
            'tmrNoonSlipAmount' => $tmrNoonSlipsAmount,
            'tmrEvenSlipAmount' => $tmrEvenSlipsAmount,
            'NetProfit' => $NoonSlipsAmount - ( $totalPayout + $NoonSlipsAmount15 ),
            'EvenNetProfit' => $EvenSlipsAmount  - ( $totalEvenPayout + $EvenSlipsAmount15 ),
            'TmrNetProfit' => $tmrNoonSlipsAmount - ( $totalTmrPayout + $tmrNoonSlipsAmount15 ),
            'TmrEvenNetProfit' => $tmrEvenSlipsAmount - ( $totalTmrEvenPayout + $tmrEvenSlipsAmount15 ),
            'date' => $date,
            'day' => $day,
            'tdate' => $tdate,
            'tday' => $tday
        ]);
    }
    
    public function viewBet(Request $request)
    {   

        $Lowintegers = range(00,24);
        $midLowintegers = range(25,49);
        $midHighintegers = range(50,74);
        $Highintegers = range(75,99);
        $date = $request->date;
        $time = $request->time;
        $LowBets = [];
        $midLowBets = [];
        $MidBets = [];
        $HighBets = [];
        // $LowBets3D = [];
        // $midLowBets3D = [];
        // $MidBets3D = [];
        // $HighBets3D = [];

        foreach($Lowintegers as $Lowinteger)
        {   
            $LowBet_to = 0;
            $LowBet_amount = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->where('bet_slips.type','D2D')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$Lowinteger)
                                ->sum('bet_integers.amount');
            $LowBet_amount += $LowBet_to;
            $LowBets[] = [
                'integer' => $Lowinteger,
                'amount' => $LowBet_amount
            ];
        }

        foreach($midLowintegers as $midLowinteger)
        {   
            $midLowBet_to = 0;
            $midLowBet_amount = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->where('bet_slips.type','D2D')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$midLowinteger)
                                ->sum('bet_integers.amount');
            $midLowBet_amount += $midLowBet_to;
            $midLowBets[] = [
                'integer' => $midLowinteger,
                'amount' => $midLowBet_amount
            ];
        }

        foreach($midHighintegers as $midHighinteger)
        {   
            $midHighBet_to = 0;
            $midHighBet_amount = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->where('bet_slips.type','D2D')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$midHighinteger)
                                ->sum('bet_integers.amount');
            $midHighBet_amount += $midHighBet_to;
            $MidBets[] = [
                'integer' => $midHighinteger,
                'amount' => $midHighBet_amount
            ];
        }

        foreach($Highintegers as $Highinteger)
        {   
            $HighBet_to = 0;
            $HighBet_amount = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->where('bet_slips.type','D2D')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$Highinteger)
                                ->sum('bet_integers.amount');
            $HighBet_amount += $HighBet_to;
            $HighBets[] = [
                'integer' => $Highinteger,
                'amount' => $HighBet_amount
            ];
        }

        // D3D Seletors

        // foreach($Lowintegers3D as $Lowinteger3D)
        // {   
        //     $LowBet_to3D = 0;
        //     $LowBet_amount3D = BetSlip::where('bet_slips.forDate', '=',$date)
        //                         ->where('bet_slips.forTime','=',$time)
        //                         ->where('bet_slips.type','D3D')
        //                         ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
        //                         ->where('bet_integers.integer','=',$Lowinteger3D)
        //                         ->sum('bet_integers.amount');
        //     $LowBet_amount3D += $LowBet_to3D;
        //     $LowBets3D[] = [
        //         'integer' => $Lowinteger3D,
        //         'amount' => $LowBet_amount3D
        //     ];
        // }

        // foreach($midLowintegers3D as $midLowinteger3D)
        // {   
        //     $midLowBet_to3D = 0;
        //     $midLowBet_amount3D = BetSlip::where('bet_slips.forDate', '=',$date)
        //                         ->where('bet_slips.forTime','=',$time)
        //                         ->where('bet_slips.type','D3D')
        //                         ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
        //                         ->where('bet_integers.integer','=',$midLowinteger3D)
        //                         ->sum('bet_integers.amount');
        //     $midLowBet_amount3D += $midLowBet_to3D;
        //     $midLowBets3D[] = [
        //         'integer' => $midLowinteger3D,
        //         'amount' => $midLowBet_amount3D
        //     ];
        // }

        // foreach($midHighintegers3D as $midHighinteger3D)
        // {   
        //     $midHighBet_to3D = 0;
        //     $midHighBet_amount3D = BetSlip::where('bet_slips.forDate', '=',$date)
        //                         ->where('bet_slips.forTime','=',$time)
        //                         ->where('bet_slips.type','D3D')
        //                         ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
        //                         ->where('bet_integers.integer','=',$midHighinteger3D)
        //                         ->sum('bet_integers.amount');
        //     $midHighBet_amount3D += $midHighBet_to3D;
        //     $MidBets3D[] = [
        //         'integer' => $midHighinteger3D,
        //         'amount' => $midHighBet_amount3D
        //     ];
        // }

        // foreach($Highintegers3D as $Highinteger3D)
        // {   
        //     $HighBet_to3D = 0;
        //     $HighBet_amount3D = BetSlip::where('bet_slips.forDate', '=',$date)
        //                         ->where('bet_slips.forTime','=',$time)
        //                         ->where('bet_slips.type','D3D')
        //                         ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
        //                         ->where('bet_integers.integer','=',$Highinteger3D)
        //                         ->sum('bet_integers.amount');
        //     $HighBet_amount3D += $HighBet_to3D;
        //     $HighBets3D[] = [
        //         'integer' => $Highinteger3D,
        //         'amount' => $HighBet_amount3D
        //     ];
        // }


        
        
        // $MidBets = BetSlip::where('bet_slips.forDate', '=',$date)
        //                         ->where('bet_slips.forTime','=',$time)
        //                         ->join('bet_integers', function ($join) {
        //                         $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
        //                              ->where('bet_slips.type','=','D2D')
        //                              ->whereBetween('bet_integers.integer',['36','70']);
        //                         })       
        //                     ->get();
        
        // $HighBets = BetSlip::where('bet_slips.forDate', '=',$date)
        //                         ->where('bet_slips.forTime','=',$time)
        //                         ->join('bet_integers', function ($join) {
        //                         $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
        //                              ->where('bet_slips.type','=','D2D')
        //                              ->whereBetween('bet_integers.integer',['71','99']);
        //                         })       
        //                     ->get();
        
        // $LowBets3D = BetSlip::where('bet_slips.forDate', '=',$date)
        //                         ->where('bet_slips.forTime','=',$time)
        //                         ->join('bet_integers', function ($join) {
        //                         $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
        //                              ->where('bet_slips.type','=','D3D')
        //                              ->whereBetween('bet_integers.integer',['000','359']);
        //                         })       
        //                     ->get();
        
        // $MidBets3D = BetSlip::where('bet_slips.forDate', '=',$date)
        //                         ->where('bet_slips.forTime','=',$time)
        //                         ->join('bet_integers', function ($join) {
        //                         $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
        //                              ->where('bet_slips.type','=','D3D')
        //                              ->whereBetween('bet_integers.integer',['360','700']);
        //                         })       
        //                     ->get();
        
        // $HighBets3D = BetSlip::where('bet_slips.forDate', '=',$date)
        //                         ->where('bet_slips.forTime','=',$time)
        //                         ->join('bet_integers', function ($join) {
        //                         $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
        //                              ->where('bet_slips.type','=','D3D')
        //                              ->whereBetween('bet_integers.integer',['701','999']);
        //                         })       
        //                     ->get();
        
        return view('admin.bet.index',[
            'lows' => $LowBets,
            'midLows' => $midLowBets,
            'mids' => $MidBets,
            'highs' => $HighBets,
            // 'bets' => $bets,
            'date' => $date,
            'time' => $time
        ]);
    }
    
    public function viewThreeDBet(Request $request)
    {   

        $Lowintegers3D = range(000,249);
        $midLowintegers3D = range(250,499);
        $midHighintegers3D = range(500,749);
        $Highintegers3D = range(750,999);
        $date = $request->date;
        $time = $request->time;
        $LowBets3D = [];
        $midLowBets3D = [];
        $MidBets3D = [];
        $HighBets3D = [];

        // D3D Seletors

        foreach($Lowintegers3D as $Lowinteger3D)
        {   
            $LowBet_to3D = 0;
            $LowBet_amount3D = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->where('bet_slips.type','D3D')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$Lowinteger3D)
                                ->sum('bet_integers.amount');
            $LowBet_amount3D += $LowBet_to3D;
            $LowBets3D[] = [
                'integer' => $Lowinteger3D,
                'amount' => $LowBet_amount3D
            ];
        }

        foreach($midLowintegers3D as $midLowinteger3D)
        {   
            $midLowBet_to3D = 0;
            $midLowBet_amount3D = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->where('bet_slips.type','D3D')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$midLowinteger3D)
                                ->sum('bet_integers.amount');
            $midLowBet_amount3D += $midLowBet_to3D;
            $midLowBets3D[] = [
                'integer' => $midLowinteger3D,
                'amount' => $midLowBet_amount3D
            ];
        }

        foreach($midHighintegers3D as $midHighinteger3D)
        {   
            $midHighBet_to3D = 0;
            $midHighBet_amount3D = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->where('bet_slips.type','D3D')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$midHighinteger3D)
                                ->sum('bet_integers.amount');
            $midHighBet_amount3D += $midHighBet_to3D;
            $MidBets3D[] = [
                'integer' => $midHighinteger3D,
                'amount' => $midHighBet_amount3D
            ];
        }

        foreach($Highintegers3D as $Highinteger3D)
        {   
            $HighBet_to3D = 0;
            $HighBet_amount3D = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->where('bet_slips.type','D3D')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$Highinteger3D)
                                ->sum('bet_integers.amount');
            $HighBet_amount3D += $HighBet_to3D;
            $HighBets3D[] = [
                'integer' => $Highinteger3D,
                'amount' => $HighBet_amount3D
            ];
        }


        
        
        // $MidBets = BetSlip::where('bet_slips.forDate', '=',$date)
        //                         ->where('bet_slips.forTime','=',$time)
        //                         ->join('bet_integers', function ($join) {
        //                         $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
        //                              ->where('bet_slips.type','=','D2D')
        //                              ->whereBetween('bet_integers.integer',['36','70']);
        //                         })       
        //                     ->get();
        
        // $HighBets = BetSlip::where('bet_slips.forDate', '=',$date)
        //                         ->where('bet_slips.forTime','=',$time)
        //                         ->join('bet_integers', function ($join) {
        //                         $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
        //                              ->where('bet_slips.type','=','D2D')
        //                              ->whereBetween('bet_integers.integer',['71','99']);
        //                         })       
        //                     ->get();
        
        // $LowBets3D = BetSlip::where('bet_slips.forDate', '=',$date)
        //                         ->where('bet_slips.forTime','=',$time)
        //                         ->join('bet_integers', function ($join) {
        //                         $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
        //                              ->where('bet_slips.type','=','D3D')
        //                              ->whereBetween('bet_integers.integer',['000','359']);
        //                         })       
        //                     ->get();
        
        // $MidBets3D = BetSlip::where('bet_slips.forDate', '=',$date)
        //                         ->where('bet_slips.forTime','=',$time)
        //                         ->join('bet_integers', function ($join) {
        //                         $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
        //                              ->where('bet_slips.type','=','D3D')
        //                              ->whereBetween('bet_integers.integer',['360','700']);
        //                         })       
        //                     ->get();
        
        // $HighBets3D = BetSlip::where('bet_slips.forDate', '=',$date)
        //                         ->where('bet_slips.forTime','=',$time)
        //                         ->join('bet_integers', function ($join) {
        //                         $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
        //                              ->where('bet_slips.type','=','D3D')
        //                              ->whereBetween('bet_integers.integer',['701','999']);
        //                         })       
        //                     ->get();
        
        return view('admin.bet.threed',[
            
            'low3s' => $LowBets3D,
            'midLow3s' => $midLowBets3D,
            'mid3s' => $MidBets3D,
            'high3s' => $HighBets3D,
            // 'bets' => $bets,
            'date' => $date,
            'time' => $time
        ]);
    }

    public function viewPlusBet(Request $request)
    {   

        $Lowintegers = range(00,24);
        $midLowintegers = range(25,49);
        $midHighintegers = range(50,74);
        $Highintegers = range(75,99);
        $date = $request->date;
        $time = $request->time;
        $LowBets = [];
        $midLowBets = [];
        $MidBets = [];
        $HighBets = [];

        foreach($Lowintegers as $Lowinteger)
        {   
            $LowBet_to = 0;
            $LowBet_amount = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->where('bet_slips.type','2DPLUS')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$Lowinteger)
                                ->sum('bet_integers.amount');
            $LowBet_amount += $LowBet_to;
            $LowBets[] = [
                'integer' => $Lowinteger,
                'amount' => $LowBet_amount
            ];
        }

        foreach($midLowintegers as $midLowinteger)
        {   
            $midLowBet_to = 0;
            $midLowBet_amount = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->where('bet_slips.type','2DPLUS')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$midLowinteger)
                                ->sum('bet_integers.amount');
            $midLowBet_amount += $midLowBet_to;
            $midLowBets[] = [
                'integer' => $midLowinteger,
                'amount' => $midLowBet_amount
            ];
        }

        foreach($midHighintegers as $midHighinteger)
        {   
            $midHighBet_to = 0;
            $midHighBet_amount = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->where('bet_slips.type','2DPLUS')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$midHighinteger)
                                ->sum('bet_integers.amount');
            $midHighBet_amount += $midHighBet_to;
            $MidBets[] = [
                'integer' => $midHighinteger,
                'amount' => $midHighBet_amount
            ];
        }

        foreach($Highintegers as $Highinteger)
        {   
            $HighBet_to = 0;
            $HighBet_amount = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->where('bet_slips.type','2DPLUS')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$Highinteger)
                                ->sum('bet_integers.amount');
            $HighBet_amount += $HighBet_to;
            $HighBets[] = [
                'integer' => $Highinteger,
                'amount' => $HighBet_amount
            ];
        }

             // $HighBets3D = BetSlip::where('bet_slips.forDate', '=',$date)
        //                         ->where('bet_slips.forTime','=',$time)
        //                         ->join('bet_integers', function ($join) {
        //                         $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
        //                              ->where('bet_slips.type','=','D3D')
        //                              ->whereBetween('bet_integers.integer',['701','999']);
        //                         })       
        //                     ->get();
        
        return view('admin.bet.twodplus',[
            'lows' => $LowBets,
            'midLows' => $midLowBets,
            'mids' => $MidBets,
            'highs' => $HighBets,
            // 'bets' => $bets,
            'date' => $date,
            'time' => $time
        ]);
    }

    public function viewInternetBet(Request $request)
    {   

        $Lowintegers = range(00,24);
        $midLowintegers = range(25,49);
        $midHighintegers = range(50,74);
        $Highintegers = range(75,99);
        $date = $request->date;
        $time = $request->time;
        $LowBets = [];
        $midLowBets = [];
        $MidBets = [];
        $HighBets = [];

        foreach($Lowintegers as $Lowinteger)
        {   
            $LowBet_to = 0;
            $LowBet_amount = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->where('bet_slips.type','INTERNET')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$Lowinteger)
                                ->sum('bet_integers.amount');
            $LowBet_amount += $LowBet_to;
            $LowBets[] = [
                'integer' => $Lowinteger,
                'amount' => $LowBet_amount
            ];
        }

        foreach($midLowintegers as $midLowinteger)
        {   
            $midLowBet_to = 0;
            $midLowBet_amount = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->where('bet_slips.type','INTERNET')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$midLowinteger)
                                ->sum('bet_integers.amount');
            $midLowBet_amount += $midLowBet_to;
            $midLowBets[] = [
                'integer' => $midLowinteger,
                'amount' => $midLowBet_amount
            ];
        }

        foreach($midHighintegers as $midHighinteger)
        {   
            $midHighBet_to = 0;
            $midHighBet_amount = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->where('bet_slips.type','INTERNET')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$midHighinteger)
                                ->sum('bet_integers.amount');
            $midHighBet_amount += $midHighBet_to;
            $MidBets[] = [
                'integer' => $midHighinteger,
                'amount' => $midHighBet_amount
            ];
        }

        foreach($Highintegers as $Highinteger)
        {   
            $HighBet_to = 0;
            $HighBet_amount = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->where('bet_slips.type','INTERNET')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$Highinteger)
                                ->sum('bet_integers.amount');
            $HighBet_amount += $HighBet_to;
            $HighBets[] = [
                'integer' => $Highinteger,
                'amount' => $HighBet_amount
            ];
        }




        
        
        // $MidBets = BetSlip::where('bet_slips.forDate', '=',$date)
        //                         ->where('bet_slips.forTime','=',$time)
        //                         ->join('bet_integers', function ($join) {
        //                         $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
        //                              ->where('bet_slips.type','=','D2D')
        //                              ->whereBetween('bet_integers.integer',['36','70']);
        //                         })       
        //                     ->get();
        
        // $HighBets = BetSlip::where('bet_slips.forDate', '=',$date)
        //                         ->where('bet_slips.forTime','=',$time)
        //                         ->join('bet_integers', function ($join) {
        //                         $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
        //                              ->where('bet_slips.type','=','D2D')
        //                              ->whereBetween('bet_integers.integer',['71','99']);
        //                         })       
        //                     ->get();
        
        // $LowBets3D = BetSlip::where('bet_slips.forDate', '=',$date)
        //                         ->where('bet_slips.forTime','=',$time)
        //                         ->join('bet_integers', function ($join) {
        //                         $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
        //                              ->where('bet_slips.type','=','D3D')
        //                              ->whereBetween('bet_integers.integer',['000','359']);
        //                         })       
        //                     ->get();
        
        // $MidBets3D = BetSlip::where('bet_slips.forDate', '=',$date)
        //                         ->where('bet_slips.forTime','=',$time)
        //                         ->join('bet_integers', function ($join) {
        //                         $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
        //                              ->where('bet_slips.type','=','D3D')
        //                              ->whereBetween('bet_integers.integer',['360','700']);
        //                         })       
        //                     ->get();
        
        // $HighBets3D = BetSlip::where('bet_slips.forDate', '=',$date)
        //                         ->where('bet_slips.forTime','=',$time)
        //                         ->join('bet_integers', function ($join) {
        //                         $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
        //                              ->where('bet_slips.type','=','D3D')
        //                              ->whereBetween('bet_integers.integer',['701','999']);
        //                         })       
        //                     ->get();
        
        return view('admin.bet.internet',[
            'lows' => $LowBets,
            'midLows' => $midLowBets,
            'mids' => $MidBets,
            'highs' => $HighBets,
            // 'bets' => $bets,
            'date' => $date,
            'time' => $time
        ]);
    }
}
