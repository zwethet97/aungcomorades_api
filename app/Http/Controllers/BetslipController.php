<?php

namespace App\Http\Controllers;
use App\Models\BetSlip;
use App\Models\BetInteger;
use App\Models\BetLimit;
use App\Models\DthreeD;
use App\Models\NormalUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class BetSlipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
     public function todayComIndex()
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
        $EvenSlipsAmount = BetSlip::where('forDate',$date)->where('forTime','4:30 PM')->sum('bet_slips.total-bet-amount');
        $tmrNoonSlipsAmount = 0;
        $tmrNoonSlipsAmount = BetSlip::where('forDate',$tdate)->where('forTime','12:01 PM')->sum('bet_slips.total-bet-amount');
        $tmrEvenSlipsAmount = 0;
        $tmrEvenSlipsAmount = BetSlip::where('forDate',$tdate)->where('forTime','4:30 PM')->sum('bet_slips.total-bet-amount');
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
                                         ->where('bet_integers.integer','=',$winNumberNoon);
                                })
                                ->get();
                $NoonBetsTwod = BetInteger::join('bet_slips', function ($join) {

                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                $winNumberNoon = DthreeD::where('date',$date)->where('time','12:01 PM')->value('3D');
                                    $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                         ->where('bet_slips.forDate', '=',$date)
                                         ->where('bet_slips.forTime','=','12:01 PM')
                                         ->where('bet_integers.integer','=',$winNumberNoon[1].$winNumberNoon[2]);
                                })
                                ->get();

                $NoonBetsRound = BetInteger::join('bet_slips', function ($join) {

                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                                    $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                         ->where('bet_slips.forDate', '=',$date)
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
                                         ->where('bet_slips.forTime','=','4:30 PM')
                                         ->where('bet_integers.integer','=',$winNumberEven);
                                })
                                ->get();

                $EvenBetsTwod = BetInteger::join('bet_slips', function ($join) {

                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                $winNumberEven = DthreeD::where('date',$date)->where('time','4:31 PM')->value('3D');
                                    $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                         ->where('bet_slips.forDate', '=',$date)
                                         ->where('bet_slips.forTime','=','4:30 PM')
                                         ->where('bet_integers.integer','=',$winNumberEven[1].$winNumberEven[2]);
                                })
                                ->get();

                $EvenBetsRound = BetInteger::join('bet_slips', function ($join) {

                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                                    $join->on('bet_slips.id', '=', 'bet_integers.bet-slip-id')
                                         ->where('bet_slips.forDate', '=',$date)
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
        $todaydata = [
            'winNumberNoon' => $winNumberNoon,
            'winNumberEven' => $winNumberEven,
            'noonPayout' => $totalPayout,
            'evenPayout' => $totalEvenPayout,
            'winNoonAmount' => $totalWinAmount,
            'winEvenAmount' => $totalEvenWinAmount,
            'tmrNoonPayout' => $totalTmrPayout,
            'tmrEvenPayout' => $totalTmrEvenPayout,
            'NoonSlipAmount' => $NoonSlipsAmount,
            'NoonCommission' => $NoonSlipsAmount * 0.15,
            'EvenSlipAmount' => $EvenSlipsAmount,
            'EvenCommission' => $EvenSlipsAmount * 0.15,
            'tmrNoonSlipAmount' => $tmrNoonSlipsAmount,
            'tmrNoonCommission' => $tmrNoonSlipsAmount * 0.15,
            'tmrEvenSlipAmount' => $tmrEvenSlipsAmount,
            'tmrEvenCommission' => $tmrEvenSlipsAmount * 0.15,
            'NetProfit' => $NoonSlipsAmount - $totalPayout,
            'EvenNetProfit' => $EvenSlipsAmount - $totalEvenPayout,
            'TmrNetProfit' => $tmrNoonSlipsAmount - $totalTmrPayout,
            'TmrNetProfit' => $tmrEvenSlipsAmount - $totalTmrEvenPayout,
            'date' => $date,
            'day' => $day,
            'tdate' => $tdate,
            'tday' => $tday
        ];
        
        return response([
            'success' => true,
            'data' => 'Betslips Found Successfully',
            'message' => $todaydata
        ],201);
    }
    
    public function viewBet(Request $request)
    {   

        $Lowintegers = range(00,99);
        $Lowintegers3D = range(000,999);
        $date = $request->date;
        $time = $request->time;
        $LowBets = [];
        $LowBets3D = [];

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
        
        $data = [
            'date' => $date,
            'time' => $time,
            'D2D' => $LowBets,
            'D3D' => $LowBets3D
            
        ];
        
        return response([
            'success' => true,
            'data' => 'Data Found Successfully',
            'message' => $data
        ],201);
    }
    
    public function index()
    {   
        return response([
            'success' => true,
            'data' => 'Betslips Found Successfully',
            'message' => BetSlip::all()
        ],201);
    }

    public function betDetail($id)
    {
        $betslip = BetSlip::where('id',$id)->first();
        $betNo = BetInteger::where('bet-slip-id',$id)->get();

        $betDetail = [
            'betslip' => $betslip,
            'betIntegerAmount' => $betNo
        ];

        return response([
            'success' => true,
            'data' => 'ID with Betslip found successfully',
            'message' => $betDetail
        ],201);
    }
    public function checkBet(Request $request)
    {   
        $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        $fields = $request->validate([
            'userId' => 'required',
            'date' => 'required',
            'time' => 'required'
        ]);
        
        $limit_amount = BetLimit::where('id',1)->value('limit');
        $limit50 = $limit_amount - 50;
        $betintegers = $request->betinteger;
        $notavail = [];
        $availamt = [];
        $avail = [];

        foreach ($betintegers as $betinteger)
        {
            $check_amt = BetSlip::where('bet_slips.forDate', '=',$request->date)
                                ->where('bet_slips.forTime','=',$request->time)
                                ->where('bet_slips.type','=','D2D')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$betinteger['integer'])
                                ->sum('bet_integers.amount');

            $stage_one = $check_amt + $betinteger['amount'];
            
            if ( $check_amt > $limit50 || $limit50 == $check_amt )
            {
                $notavail[] = $betinteger['integer'];
            }
            elseif( $stage_one > $limit50   || $betinteger['amount'] >= $limit_amount ) 
            {  
                $availamt[] = [
                    'number' => $betinteger['integer'],
                    'available amount' => $limit50 - $check_amt 
                ];
            }
            else
            {
                $avail[] = [
                    'number' => $betinteger['integer'],
                    'amount' => $betinteger['amount']
                ];
            }

        }
        
        $status = [
                'Not Available Number' => $notavail,
                'Only Available Amount' => $availamt,
                'Available' => $avail
            ];
            
        // if ( empty($notavail) && empty($availamt) )
        //     {
        //         return true;
        //     }
            return response([
                'success' => true,
                'message' => 'Available & Not Available No.',
                'data' => $status
            ],200);  
    }

    public function check3dBet(Request $request)
    {   
        $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        $fields = $request->validate([
            'userId' => 'required',
            'date' => 'required',
            'time' => 'required'
        ]);
        
        $limit_amount = BetLimit::where('id',2)->value('limit');
        $limit50 = $limit_amount - 50;
        $betintegers = $request->betinteger;
        $notavail = [];
        $availamt = [];
        $avail = [];

        foreach ($betintegers as $betinteger)
        {
            $check_amt = BetSlip::where('bet_slips.forDate', '=',$request->date)
                                ->where('bet_slips.forTime','=',$request->time)
                                ->where('bet_slips.type','=','D3D')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$betinteger['integer'])
                                ->sum('bet_integers.amount');

            $stage_one = $check_amt + $betinteger['amount'];
            
            if ( $check_amt > $limit50 || $limit50 == $check_amt )
            {
                $notavail[] = $betinteger['integer'];
            }
            elseif( $stage_one > $limit50  || $betinteger['amount'] >= $limit_amount  ) 
            {   
                
                $availamt[] = [
                    'number' => $betinteger['integer'],
                    'available amount' => $limit50 - $check_amt 
                ];
            }
            else
            {
                $avail[] = [
                    'number' => $betinteger['integer'],
                    'amount' => $betinteger['amount']
                ];
            }

        }
        
        $status = [
                'Not Available Number' => $notavail,
                'Only Available Amount' => $availamt,
                'Available' => $avail
            ];
            
        // if ( empty($notavail) && empty($availamt) )
        //     {
        //         return true;
        //     }
            return response([
                'success' => true,
                'message' => 'Available & Not Available No.',
                'data' => $status
            ],200);  
    }
    
    
    public function checkInternetBet(Request $request)
    {   
        $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        $fields = $request->validate([
            'userId' => 'required',
            'date' => 'required',
            'time' => 'required'
        ]);
        
        $limit_amount = BetLimit::where('id',3)->value('limit');
        $limit50 = $limit_amount - 50;
        $betintegers = $request->betinteger;
        $notavail = [];
        $availamt = [];
        $avail = [];

        foreach ($betintegers as $betinteger)
        {
            $check_amt = BetSlip::where('bet_slips.forDate', '=',$request->date)
                                ->where('bet_slips.forTime','=',$request->time)
                                ->where('bet_slips.type','=','INTERNET')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$betinteger['integer'])
                                ->sum('bet_integers.amount');

            $stage_one = $check_amt + $betinteger['amount'];
            
            if ( $check_amt > $limit50 || $limit50 == $check_amt )
            {
                $notavail[] = $betinteger['integer'];
            }
            elseif( $stage_one > $limit50  || $betinteger['amount'] >= $limit_amount  ) 
            {   
                
                $availamt[] = [
                    'number' => $betinteger['integer'],
                    'available amount' => $limit50 - $check_amt 
                ];
            }
            else
            {
                $avail[] = [
                    'number' => $betinteger['integer'],
                    'amount' => $betinteger['amount']
                ];
            }

        }
        
        $status = [
                'Not Available Number' => $notavail,
                'Only Available Amount' => $availamt,
                'Available' => $avail
            ];
            
        // if ( empty($notavail) && empty($availamt) )
        //     {
        //         return true;
        //     }
            return response([
                'success' => true,
                'message' => 'Available & Not Available No.',
                'data' => $status
            ],200);  
    }
    
    public function check2dplusBet(Request $request)
    {   
        $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        $fields = $request->validate([
            'userId' => 'required',
            'date' => 'required',
            'time' => 'required'
        ]);
        
        $limit_amount = BetLimit::where('id',4)->value('limit');
        $limit50 = $limit_amount - 50;
        $betintegers = $request->betinteger;
        $notavail = [];
        $availamt = [];
        $avail = [];

        foreach ($betintegers as $betinteger)
        {
            $check_amt = BetSlip::where('bet_slips.forDate', '=',$request->date)
                                ->where('bet_slips.forTime','=',$request->time)
                                ->where('bet_slips.type','=','2DPLUS')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$betinteger['integer'])
                                ->sum('bet_integers.amount');

            $stage_one = $check_amt + $betinteger['amount'];
            
            if ( $check_amt > $limit50 || $limit50 == $check_amt )
            {
                $notavail[] = $betinteger['integer'];
            }
            elseif( $stage_one > $limit50  || $betinteger['amount'] >= $limit_amount  ) 
            {   
                
                $availamt[] = [
                    'number' => $betinteger['integer'],
                    'available amount' => $limit50 - $check_amt 
                ];
            }
            else
            {
                $avail[] = [
                    'number' => $betinteger['integer'],
                    'amount' => $betinteger['amount']
                ];
            }

        }
        
        $status = [
                'Not Available Number' => $notavail,
                'Only Available Amount' => $availamt,
                'Available' => $avail
            ];
            
        // if ( empty($notavail) && empty($availamt) )
        //     {
        //         return true;
        //     }
            return response([
                'success' => true,
                'message' => 'Available & Not Available No.',
                'data' => $status
            ],200);  
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'userId' => 'required',
            'total-bet-amount' =>'required',
            'forDate' => 'required',
            'forTime' => 'required',
            'type' => 'required',
            'selected-total-number' => 'required'
        ]);

        if ( NormalUser::where('id',$fields['userId'])->value('credits') < $fields['total-bet-amount'] )
        {
            return response([
                'success' => false,
                'message' => 'Do not enough credits',
                'data' => []
            ],200); 
        }
        
        $betslip = BetSlip::create([

            'userId' => $fields['userId'],
            'total-bet-amount' => $fields['total-bet-amount'],
            'forDate' => $fields['forDate'],
            'forTime' => $fields['forTime'],
            'type' => $fields['type'],
            'selected-total-number' => $fields['selected-total-number'],
            'status' => 'ongoing',
            'win_number' => 'ongoing',
            'referral' => '0',
            'reward' => '0',
            'created_at' => Carbon::now('Asia/Yangon'),
            'updated_at' => Carbon::now('Asia/Yangon')
        ]);
        
        $betintegers = $request->betinteger;
        foreach ( $betintegers as $betinteger )
        {
            BetInteger::create([
                'integer' => $betinteger['integer'],
                'amount' => $betinteger['amount'],
                'bet-slip-id' => $betslip->id
            ]);
        }

        $response = [
            'betslip' => $betslip,
            'bets' => $betintegers
        ];
        
        $existamount = NormalUser::where('id',$fields['userId'])->value('credits');
        NormalUser::where('id',$fields['userId'])->update([
            'credits' => $existamount - $fields['total-bet-amount']
        ]);

        return response([
            'success' => true,
            'data' => 'Data Created Successfully',
            'message' => $response
        ],201);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bet = BetSlip::find($id);
        $bet->update($request->all());
        return response([
            'success' => true,
            'data' => 'Data Updated Successfully',
            'message' => $bet
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return BetSlip::destroy($id);
        
    }
    
    public function search($name)
    {   
        $userId = NormalUser::where('id', 'like', '%'.$name.'%')->get();
        if (!NormalUser::where('id', 'like', '%'.$name.'%')->first())
        {
            return response([
                'success' => false,
                'data' => 'No Betslips!',
                'message' => []
            ],200);
        }

        $betslips = BetSlip::where('userId', 'like', '%'.$name.'%')->orderBy('id','DESC')->get();
        $betintegers = [];

        foreach($betslips as $betslip)
        {
            $betintegers[] = [
                'betslip' => $betslip,
                'betInteger' => BetInteger::where('bet-slip-id',$betslip->id)->get()
            ];
        }
         
        return response([
            'success' => true,
            'data' => 'BetSlip for UserID Data Found Successfully',
            'message' => $betintegers
        ],200);
    }
}
