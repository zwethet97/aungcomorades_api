<?php

namespace App\Http\Controllers;
use App\Models\BetSlip;
use App\Models\BetInteger;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class BetslipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BetSlip::all();
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
            'bet-numbers' => 'required',
            'selected-total-number' => 'required'
        ]);
        
        $betslip = BetSlip::create([

            'userId' => $fields['userId'],
            'total-bet-amount' => $fields['total-bet-amount'],
            'forDate' => $fields['forDate'],
            'forTime' => $fields['forTime'],
            'type' => $fields['type'],
            'bet-numbers' => $fields['bet-numbers'],
            'selected-total-number' => $fields['selected-total-number'],
            'status' => 'ongoing'
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
        
        return response($response,201);
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
        return $user;
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
        return Bettors::where('userId', 'like', '%'.$name.'%')->get();
    }
}
