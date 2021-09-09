<?php

namespace App\Http\Controllers;
use App\Models\BetInteger;
use App\Models\BetSlip;
use App\Models\NormalUser;
use App\Models\DtwoD;
use App\Models\DthreeD;
use App\Models\ThaiThreeD;
use Illuminate\Http\Request;

class BetCheckController extends Controller
{
    public function checkBet()
    {
        $Bets = BetInteger::all();
        $WinNumber = DtwoD::all();
        
        foreach ( $WinNumber as $WinNumbers )
        {   
            $Win = BetInteger::where('integer', $WinNumbers['2D'])->exists();
           if ( $Win )
           {    
               $slip = BetInteger::where('integer', $WinNumbers['2D'])->first();   
                $WinBetSlip = BetSlip::where('id',$slip->id)->first();

                return $WinBetSlip;

               if ( $WinBetSlip->forDate == $WinNumbers['date'] || $WinBetSlip->forTime == $WinNumbers['time'] )
               {
                    return true;
                    // $WinBetSlip->update([
                    //     'status' => 'win'
                    // ]);
                    // $WinUser = NormalUser::where('id',$WinBetSlip->userId)->first();
                    // $UpdateAmount = $Win->amount * 8;
                    // $WinUser->update([
                    //     'amount' => $WinUser->amount + $UpdateAmount
                    // ]);
                    // return response([
                    //     'message' => 'Changed Successfully'
                    // ],200);
               }
           }
        }
        
    }
}
