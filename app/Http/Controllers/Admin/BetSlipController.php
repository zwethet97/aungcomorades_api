<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BetSlip;
use App\Models\DthreeD;
use App\Models\Internet;
use App\Models\NormalUser;
use App\Models\Transaction;
use App\Models\User;
use App\Models\BetInteger;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class BetSlipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {   
        $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        $noonSlips = BetSlip::where('forDate',$date)->whereIn('forTime',['09:30 AM','12:01 PM'])->where('status','ongoing')->count();
        $evenSlips = BetSlip::where('forDate',$date)->whereIn('forTime',['2:00 PM','4:30 PM'])->where('status','ongoing')->count();
        
        return view('admin.betslip.index',[
            'betslips' => BetSlip::all(),
            'nooncount' => $noonSlips,
            'evencount' => $evenSlips
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    
    // public function noonSlipChange(Request $request)
    // {   
        
    //     $request->validate([
    //         'password' => 'required' 
    //      ]);
 
    //      $admin = User::where('id','1')->first();
         
    //      if (!Hash::check($request->password,$admin->password))
    //      {
    //          return back()->with('message','Password is not correct');
    //      }

    //     $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
    //     $winNoThree = DthreeD::where('date',$date)->where('time','12:01 PM')->value('3D');
    //     $winNoPlus = DthreeD::where('date',$date)->where('time','12:01 PM')->value('plustwod');
    //     $winNoInternet = Internet::where('date',$date)->where('time','9:30 AM')->value('internet');
        
        
    //     if ($winNoInternet)
    //     {
    //         $loseInternet = BetSlip::where('forDate',$date)->where('forTime','09:30 AM')->get();
    //         $loseInternet->update([
    //             'status' => 'lose',
    //             'win_number' => $winNoInternet
    //             ]);
                
    //         if ($winNoThree)
            
    //         {
    //             $loseThree = BetSlip::where('forDate',$date)->where('forTime','12:01 PM')->whereIn('type',['D2D','D3D'])->get();
    //             $loseThree->update([
    //             'status' => 'lose',
    //             'win_number' => $winNoThree
    //             ]);
                
    //             $losePlus = BetSlip::where('forDate',$date)->where('forTime','12:01 PM')->whereIn('type',['D2D','D3D'])->get();
    //             $losePlus->update([
    //             'status' => 'lose',
    //             'win_number' => $winNoPlus
    //             ]);
    //         }
            
    //     }
    // }
    
    // public function evenSlipChange(Request $request)
    // {   
        
    //     $request->validate([
    //         'password' => 'required' 
    //      ]);
 
    //      $admin = User::where('id','1')->first();
         
    //      if (!Hash::check($request->password,$admin->password))
    //      {
    //          return back()->with('message','Password is not correct');
    //      }

    //     $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
    //     $winNoThree = DthreeD::where('date',$date)->where('time','4:31 PM')->value('3D');
    //     $winNoPlus = DthreeD::where('date',$date)->where('time','4:31 PM')->value('plustwod');
    //     $winNoInternet = Internet::where('date',$date)->where('time','2:00 PM')->value('internet');
        
        
    //     if ($winNoInternet)
    //     {
    //         $loseInternet = BetSlip::where('forDate',$date)->where('forTime','02:00 PM')->get();
    //         $loseInternet->update([
    //             'status' => 'lose',
    //             'win_number' => $winNoInternet
    //             ]);
                
    //         if ($winNoThree)
            
    //         {
    //             $loseThree = BetSlip::where('forDate',$date)->where('forTime','4:30 PM')->whereIn('type',['D2D','D3D'])->get();
    //             $loseThree->update([
    //             'status' => 'lose',
    //             'win_number' => $winNoThree
    //             ]);
                
    //             $losePlus = BetSlip::where('forDate',$date)->where('forTime','4:30 PM')->whereIn('type',['D2D','D3D'])->get();
    //             $losePlus->update([
    //             'status' => 'lose',
    //             'win_number' => $winNoPlus
    //             ]);
    //         }
            
    //     }
    // }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $betslip = BetSlip::find($id);
        return view('admin.betslip.detail',[
            'betslipid' => BetSlip::find($id),
            'betslipuser' => NormalUser::where('id',$betslip->userId)->first(),
            'betintegers' => BetInteger::where('bet-slip-id',$id)->get()
        ]);
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
