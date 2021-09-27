<?php

namespace App\Http\Controllers;
use App\Models\BetInteger;
use App\Models\BetSlip;
use App\Models\NormalUser;
use App\Models\DtwoD;
use App\Models\DthreeD;
use App\Models\ThaiThreeD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BetCheckController extends Controller
{
    public function checkBet()
    {
        $twod = DB::table('bet_integers')
                ->join('dtwo_d_s', 'bet_integers.integer','=', 'dtwo_d_s.2D')
                ->select('bet_integers.integer','bet_integers.amount','bet_integers.bet-slip-id')
                ->get();

        $decodes = json_decode($twod,true);

        foreach ( $decodes as $decode )
        {
            BetSlip::where('id',$decode['bet-slip-id'])->update([
                'status' => 'winning'
            ]);
        }
        
        return true;
    }

}
