<?php

namespace App\Http\Controllers;
use App\Models\DthreeD;
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
        $NoonSlipsAmount = BetSlip::where('forDate',$date)->where('forTime','12:01 PM')->sum('bet_slips.total-bet-amount');
        $EvenSlipsAmount = 0;
        $EvenSlipsAmount = BetSlip::where('forDate',$date)->where('forTime','4:31 PM')->sum('bet_slips.total-bet-amount');
        $tmrNoonSlipsAmount = 0;
        $tmrNoonSlipsAmount = BetSlip::where('forDate',$tdate)->where('forTime','12:01 PM')->sum('bet_slips.total-bet-amount');
        $tmrEvenSlipsAmount = 0;
        $tmrEvenSlipsAmount = BetSlip::where('forDate',$tdate)->where('forTime','4:31 PM')->sum('bet_slips.total-bet-amount');
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
                                         ->where('bet_slips.forTime','=','12:01 PM')
                                         ->where('bet_slips.status','=','ongoing')
                                         ->where('bet_integers.integer','=',$winNumberNoon);
                                })
                                ->get();
                $NoonBetsTwod = BetInteger::join('bet_slips', function ($join) {

                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                $winNumberNoon = DthreeD::where('date',$date)->where('time','12:01 PM')->value('3D');
                                    $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                         ->where('bet_slips.forDate', '=',$date)
                                         ->where('bet_slips.forTime','=','12:01 PM')
                                         ->where('bet_slips.status','=','ongoing')
                                         ->where('bet_integers.integer','=',$winNumberNoon[1].$winNumberNoon[2]);
                                })
                                ->get();

                $NoonBetsRound = BetInteger::join('bet_slips', function ($join) {

                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                                    $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                         ->where('bet_slips.forDate', '=',$date)
                                         ->where('bet_slips.forTime','=','12:01 PM')
                                         ->where('bet_slips.status','=','ongoing')
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

                if ( $NoonBetsTwod )

                {
                    foreach ($NoonBetsTwod as $NoonBetTwod)
                    {
                        $totalPayout += $NoonBetTwod['amount'] * 80;
                        $totalWinAmount += $NoonBetTwod['amount'];
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
                                         ->where('bet_slips.forTime','=','4:31 PM')
                                         ->where('bet_slips.status','=','ongoing')
                                         ->where('bet_integers.integer','=',$winNumberEven);
                                })
                                ->get();
                $EvenBetsTwod = BetInteger::join('bet_slips', function ($join) {

                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                $winNumberEven = DthreeD::where('date',$date)->where('time','4:31 PM')->value('3D');
                                    $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                         ->where('bet_slips.forDate', '=',$date)
                                         ->where('bet_slips.forTime','=','4:31 PM')
                                         ->where('bet_slips.status','=','ongoing')
                                         ->where('bet_integers.integer','=',$winNumberEven[1].$winNumberEven[2]);
                                })
                                ->get();

                $EvenBetsRound = BetInteger::join('bet_slips', function ($join) {

                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                                    $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                         ->where('bet_slips.forDate', '=',$date)
                                         ->where('bet_slips.forTime','=','4:31 PM')
                                         ->where('bet_slips.status','=','ongoing')
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

                if ( $EvenBetsTwod )

                {
                    foreach ($EvenBetsTwod as $EvenBetTwod)
                    {
                        $totalEvenPayout += $EvenBetTwod['amount'] * 80;
                        $totalEvenWinAmount += $EvenBetTwod['amount'];

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
            'NetProfit' => $NoonSlipsAmount - $totalPayout,
            'EvenNetProfit' => $EvenSlipsAmount - $totalEvenPayout,
            'TmrNetProfit' => $tmrNoonSlipsAmount - $totalTmrPayout,
            'TmrNetProfit' => $tmrEvenSlipsAmount - $totalTmrEvenPayout,
            'date' => $date,
            'day' => $day,
            'tdate' => $tdate,
            'tday' => $tday
        ]);


    }

    public function viewBet(Request $request)
    {
        $date = $request->date;
        $time = $request->time;
        $LowBets = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->join('bet_integers', function ($join) {
                                $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                     ->where('bet_slips.type','=','D2D')
                                     ->whereBetween('bet_integers.integer',['00','35']);
                                })       
                            ->get();
        
        $MidBets = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->join('bet_integers', function ($join) {
                                $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                     ->where('bet_slips.type','=','D2D')
                                     ->whereBetween('bet_integers.integer',['36','70']);
                                })       
                            ->get();
        
        $HighBets = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->join('bet_integers', function ($join) {
                                $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                     ->where('bet_slips.type','=','D2D')
                                     ->whereBetween('bet_integers.integer',['71','99']);
                                })       
                            ->get();
        
        $LowBets3D = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->join('bet_integers', function ($join) {
                                $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                     ->where('bet_slips.type','=','D3D')
                                     ->whereBetween('bet_integers.integer',['000','359']);
                                })       
                            ->get();
        
        $MidBets3D = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->join('bet_integers', function ($join) {
                                $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                     ->where('bet_slips.type','=','D3D')
                                     ->whereBetween('bet_integers.integer',['360','700']);
                                })       
                            ->get();
        
        $HighBets3D = BetSlip::where('bet_slips.forDate', '=',$date)
                                ->where('bet_slips.forTime','=',$time)
                                ->join('bet_integers', function ($join) {
                                $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                     ->where('bet_slips.type','=','D3D')
                                     ->whereBetween('bet_integers.integer',['701','999']);
                                })       
                            ->get();
        
        return view('admin.bet.index',[
            'lows' => $LowBets,
            'mids' => $MidBets,
            'highs' => $HighBets,
            'low3s' => $LowBets3D,
            'mid3s' => $MidBets3D,
            'high3s' => $HighBets3D,
            'date' => $date,
            'time' => $time
        ]);
    }
}
