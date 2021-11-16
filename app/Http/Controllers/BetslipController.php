<?php

namespace App\Http\Controllers;
use App\Models\BetSlip;
use App\Models\BetInteger;
use App\Models\BetLimit;
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
            
            if ( $check_amt > $limit50  || $betinteger['amount'] >= $limit_amount )
            {
                $notavail[] = $betinteger['integer'];
            }
            elseif( $stage_one > $limit50 ) 
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
                                ->where('bet_slips.type','=','D3D')
                                ->join('bet_integers','bet_slips.id','=','bet_integers.bet-slip-id')
                                ->where('bet_integers.integer','=',$betinteger['integer'])
                                ->sum('bet_integers.amount');

            $stage_one = $check_amt + $betinteger['amount'];
            
            if ( $check_amt > $limit50  || $betinteger['amount'] >= $limit_amount )
            {
                $notavail[] = $betinteger['integer'];
            }
            elseif( $stage_one > $limit50 ) 
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
            'reward' => '0'
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
