<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BetSlip;
use App\Models\BetInteger;
use App\Models\DthreeD;
use App\Models\User;
use App\Models\NormalUser;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompensateController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {   
        $currentDay = Carbon::now('Asia/Yangon')->format('d');
        $currentMonth = Carbon::now('Asia/Yangon')->format('m');
        $currentYear = Carbon::now('Asia/Yangon')->format('Y');
        $noon = Carbon::create($currentYear,$currentMonth,$currentDay,12,01,00,'Asia/Yangon');
        $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        $time =  Carbon::now('Asia/Yangon');
        $winNumberNoon = DthreeD::where('date',$date)->where('time','12:01 PM')->value('3D');
        $winNumberEven = DthreeD::where('date',$date)->where('time','4:31 PM')->value('3D');
        
        if ( $time->gt($noon) || !$time->isWeekend() )
        {   
            $winSlipNoon = [];
            $winSlipEven = [];
            $selectIntegersEven = BetInteger::where('integer', $winNumberEven)->get();
            $selectIntegers = BetInteger::where('integer',$winNumberNoon)->get();

            foreach( $selectIntegers as $selectInteger )
            {
                $checkSlip = BetSlip::where('id',$selectInteger['bet-slip-id'])->where('type','D3D')->where('status','ongoing')->first();
                
                if (!(empty($checkSlip)))

                {
                    if ( $checkSlip->forDate == $date || $checkSlip->forTime == '12:01 PM' )
                
                {   
                    
                    $winSlipNoon[] = [
                        'betslip' => $checkSlip,
                        'betinteger' => $selectInteger,
                        'user' => NormalUser::where('id',$checkSlip->userId)->first()
                    ];
                }
            }

            }

            foreach( $selectIntegersEven as $selectIntegerEven )
            {
                $checkSlip = BetSlip::where('id',$selectIntegerEven['bet-slip-id'])->where('status','ongoing')->first();
                if (!(empty($checkSlip)))
                {
                if ( $checkSlip->forDate == $date || $checkSlip->forTime == '4:31 PM')
                {
                    $winSlipEven[] = [
                        'betslip' => $checkSlip,
                        'betinteger' => $selectIntegerEven,
                        'user' => NormalUser::where('id',$checkSlip->userId)->first()
                    ];
                }
            }
            }

            return view('admin.compensate.index',[
                'winslips' => $winSlipNoon,
                'winslipsEven' => $winSlipEven,
                'winNumberNoon' => $winNumberNoon,
                'winNumberEven' => $winNumberEven
            ]);
        }

        return view('admin.compensate.index',[
            'winNumberNoon' => $winNumberNoon,
            'winNumberEven' => $winNumberEven,
            'winslipsEven' => [],
            'winslips' => []
        ]);
    }

    public function roundIndex()
    {   
        $currentDay = Carbon::now('Asia/Yangon')->format('d');
        $currentMonth = Carbon::now('Asia/Yangon')->format('m');
        $currentYear = Carbon::now('Asia/Yangon')->format('Y');
        $noon = Carbon::create($currentYear,$currentMonth,$currentDay,12,01,00,'Asia/Yangon');
        $even = Carbon::create($currentYear,$currentMonth,$currentDay,4,31,00,'Asia/Yangon');
        $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        $time =  Carbon::now('Asia/Yangon');
        $day = Carbon::now('Asia/Yangon')->format('l');
        $winNumberNoon = DthreeD::where('date',$date)->where('time','12:01 PM')->value('3D');
        
        $winNumberEven = DthreeD::where('date',$date)->where('time','4:31 PM')->value('3D');
        
        if ( $time->gt($noon) || !$time->isWeekend() )
        {   
            $winSlipNoon = [];
            $winSlipEven = [];
            
            if ( $winNumberNoon )
            {
                $selectIntegers = BetInteger::where('integer',$winNumberNoon + 1)
                                    ->orWhere('integer',$winNumberNoon - 1)
                                    ->orWhere('integer',$winNumberNoon[1].$winNumberNoon[2].$winNumberNoon[0])
                                    ->orWhere('integer',$winNumberNoon[1].$winNumberNoon[0].$winNumberNoon[2])
                                    ->orWhere('integer',$winNumberNoon[2].$winNumberNoon[0].$winNumberNoon[1])
                                    ->orWhere('integer',$winNumberNoon[2].$winNumberNoon[1].$winNumberNoon[0])
                                    ->orWhere('integer',$winNumberNoon[0].$winNumberNoon[2].$winNumberNoon[1])
                                    ->get();

            foreach( $selectIntegers as $selectInteger )
            {
                $checkSlip = BetSlip::where('id',$selectInteger['bet-slip-id'])->where('type','D3D')->where('status','ongoing')->first();
                
                if (!(empty($checkSlip)))

                {
                    if ( $checkSlip->forDate == $date || $checkSlip->forTime == '12:01 PM' )
                
                {    
                    $winSlipNoon[] = [
                        'betslip' => $checkSlip,
                        'betinteger' => $selectInteger,
                        'user' => NormalUser::where('id',$checkSlip->userId)->first()
                    ];
                }
            }

            }
            }

            if ( $time->gt($even) )
            {
                if ( $winNumberEven )
                {
                    $selectIntegersEven = BetInteger::where('integer', $winNumberEven + 1)
                                    ->orWhere('integer',$winNumberEven - 1)
                                    ->orWhere('integer',$winNumberEven[1].$winNumberEven[2].$winNumberEven[0])
                                    ->orWhere('integer',$winNumberEven[1].$winNumberEven[0].$winNumberEven[2])
                                    ->orWhere('integer',$winNumberEven[2].$winNumberEven[0].$winNumberEven[1])
                                    ->orWhere('integer',$winNumberEven[2].$winNumberEven[1].$winNumberEven[0])
                                    ->orWhere('integer',$winNumberEven[0].$winNumberEven[2].$winNumberEven[1])
                                    ->get();

            foreach( $selectIntegersEven as $selectIntegerEven )
            {
                $checkSlip = BetSlip::where('id',$selectIntegerEven['bet-slip-id'])->where('status','ongoing')->first();
                if (!(empty($checkSlip)))
                {
                if ( $checkSlip->forDate == $date || $checkSlip->forTime == '4:31 PM')
                {
                    $winSlipEven[] = [
                        'betslip' => $checkSlip,
                        'betinteger' => $selectIntegerEven,
                        'user' => NormalUser::where('id',$checkSlip->userId)->first()
                    ];
                }
            }
            }
                }
            }

            return view('admin.compensate.round',[
                'winslips' => $winSlipNoon,
                'winslipsEven' => $winSlipEven,
                'winNumberNoon' => $winNumberNoon,
                'winNumberEven' => $winNumberEven
            ]);
        }

        return view('admin.compensate.round',[
            'winNumberNoon' => $winNumberNoon,
            'winNumberEven' => $winNumberEven,
            'winslipsEven' => [],
            'winslips' => []
        ]);
    }

    public function roundCompensate(Request $request)
    {   
        $request->validate([
            'password' => 'required' 
         ]);
 
         $admin = User::where('id','1')->first();
         
         if (!Hash::check($request->password,$admin->password))
         {
             return back()->with('message','Password is not correct');
         }

        $currentDay = Carbon::now('Asia/Yangon')->format('d');
        $currentMonth = Carbon::now('Asia/Yangon')->format('m');
        $currentYear = Carbon::now('Asia/Yangon')->format('Y');
        $noon = Carbon::create($currentYear,$currentMonth,$currentDay,12,01,00,'Asia/Yangon');
        $even = Carbon::create($currentYear,$currentMonth,$currentDay,4,31,00,'Asia/Yangon');
        $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        $time =  Carbon::now('Asia/Yangon');
        $day = Carbon::now('Asia/Yangon')->format('l');
        $winNumberNoon = DthreeD::where('date',$date)->where('time','12:01 PM')->value('3D');
        
        $winNumberEven = DthreeD::where('date',$date)->where('time','4:31 PM')->value('3D');
        
        if ( $time->gt($noon) || !$time->isWeekend() )
        {   
            $winSlipNoon = [];
            $winSlipEven = [];
            
            if ( $winNumberNoon )
            {
                $selectIntegers = BetInteger::where('integer',$winNumberNoon + 1)
                                    ->orWhere('integer',$winNumberNoon - 1)
                                    ->orWhere('integer',$winNumberNoon[1].$winNumberNoon[2].$winNumberNoon[0])
                                    ->orWhere('integer',$winNumberNoon[1].$winNumberNoon[0].$winNumberNoon[2])
                                    ->orWhere('integer',$winNumberNoon[2].$winNumberNoon[0].$winNumberNoon[1])
                                    ->orWhere('integer',$winNumberNoon[2].$winNumberNoon[1].$winNumberNoon[0])
                                    ->orWhere('integer',$winNumberNoon[0].$winNumberNoon[2].$winNumberNoon[1])
                                    ->get();

            foreach( $selectIntegers as $selectInteger )
            {
                $checkSlip = BetSlip::where('id',$selectInteger['bet-slip-id'])->where('type','D3D')->where('status','ongoing')->first();
                
                if (!(empty($checkSlip)))

                {
                    if ( $checkSlip->forDate == $date || $checkSlip->forTime == '12:01 PM' )
                
                {    
                
                    $checkSlip->update([
                        'status' => 'win'
                    ]);

                    $win_user = NormalUser::where('id',$checkSlip->userId)->first();

                    $win_amount = $selectInteger->amount * 10;

                    $win_user->update([
                        'credits' => $win_user->credits + $win_amount
                    ]);
                }
            }

            }
            }

            if ( $time->gt($even) )
            {
                if ( $winNumberEven )
                {
                    $selectIntegersEven = BetInteger::where('integer', $winNumberEven + 1)
                                    ->orWhere('integer',$winNumberEven - 1)
                                    ->orWhere('integer',$winNumberEven[1].$winNumberEven[2].$winNumberEven[0])
                                    ->orWhere('integer',$winNumberEven[1].$winNumberEven[0].$winNumberEven[2])
                                    ->orWhere('integer',$winNumberEven[2].$winNumberEven[0].$winNumberEven[1])
                                    ->orWhere('integer',$winNumberEven[2].$winNumberEven[1].$winNumberEven[0])
                                    ->orWhere('integer',$winNumberEven[0].$winNumberEven[2].$winNumberEven[1])
                                    ->get();

            foreach( $selectIntegersEven as $selectIntegerEven )
            {
                $checkSlip = BetSlip::where('id',$selectIntegerEven['bet-slip-id'])->where('status','ongoing')->first();
                if (!(empty($checkSlip)))
                {
                if ( $checkSlip->forDate == $date || $checkSlip->forTime == '4:31 PM')
                {
                    
                    $checkSlip->update([
                        'status' => 'win'
                    ]);

                    $win_user = NormalUser::where('id',$checkSlip->userId)->first();

                    $win_amount = $selectIntegerEven->amount * 10;

                    $win_user->update([
                        'credits' => $win_user->credits + $win_amount
                    ]);
                }
            }
            }
                }
            }

            return back()->with('message','D3D Compensation Success!');
        }

        return back()->with('message','D3D Compensation Not Available!');

    }

    public function compensateThreed(Request $request){

        $request->validate([
            'password' => 'required' 
         ]);
 
         $admin = User::where('id','1')->first();
         
         if (!Hash::check($request->password,$admin->password))
         {
             return back()->with('message','Password is not correct');
         }

        $currentDay = Carbon::now('Asia/Yangon')->format('d');
        $currentMonth = Carbon::now('Asia/Yangon')->format('m');
        $currentYear = Carbon::now('Asia/Yangon')->format('Y');
        $noon = Carbon::create($currentYear,$currentMonth,$currentDay,12,01,00,'Asia/Yangon');
        $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        $time =  Carbon::now('Asia/Yangon');
        $winNumberNoon = DthreeD::where('date',$date)->where('time','12:01 PM')->value('3D');
        $winNumberEven = DthreeD::where('date',$date)->where('time','4:31 PM')->value('3D');
        
        if ( $time->gt($noon) || !$time->isWeekend() )
        {   
            $winSlipNoon = [];
            $winSlipEven = [];
            $selectIntegersEven = BetInteger::where('integer', $winNumberEven)->get();
            $selectIntegers = BetInteger::where('integer',$winNumberNoon)->get();

            foreach( $selectIntegers as $selectInteger )
            {
                $checkSlip = BetSlip::where('id',$selectInteger['bet-slip-id'])->where('type','D3D')->where('status','ongoing')->first();
                
                if (!(empty($checkSlip)))

                {
                    if ( $checkSlip->forDate == $date || $checkSlip->forTime == '12:01 PM' )
                
                {   
                    
                    $winSlipNoon[] = [
                        'betslip' => $checkSlip,
                        'betinteger' => $selectInteger,
                        'user' => NormalUser::where('id',$checkSlip->userId)->first()
                    ];

                    $checkSlip->update([
                        'status' => 'win'
                    ]);

                    $win_user = NormalUser::where('id',$checkSlip->userId)->first();

                    $win_amount = $selectInteger->amount * 500;

                    $win_user->update([
                        'credits' => $win_user->credits + $win_amount
                    ]);
                }
            }

            }

            foreach( $selectIntegersEven as $selectIntegerEven )
            {
                $checkSlip = BetSlip::where('id',$selectIntegerEven['bet-slip-id'])->where('status','ongoing')->first();
                if (!(empty($checkSlip)))
                {
                if ( $checkSlip->forDate == $date || $checkSlip->forTime == '4:31 PM')
                {
                    $winSlipEven[] = [
                        'betslip' => $checkSlip,
                        'betinteger' => $selectIntegerEven,
                        'user' => NormalUser::where('id',$checkSlip->userId)->first()
                    ];

                    $checkSlip->update([
                        'status' => 'win'
                    ]);

                    $win_user = NormalUser::where('id',$checkSlip->userId)->first();

                    $win_amount = $selectIntegerEven->amount * 500;

                    $win_user->update([
                        'credits' => $win_user->credits + $win_amount
                    ]);
                }
            }
            }

            return back()->with('message','D3D Compensation Success!');
        }

        return back()->with('message','D3D Compensation Not Available!');
    }

    public function compensateTwod(Request $request){
        
        $request->validate([
           'password' => 'required' 
        ]);

        $admin = User::where('id','1')->first();
        
        if (!Hash::check($request->password,$admin->password))
        {
            return back()->with('message','Password is not correct');
        }

        $currentDay = Carbon::now('Asia/Yangon')->format('d');
        $currentMonth = Carbon::now('Asia/Yangon')->format('m');
        $currentYear = Carbon::now('Asia/Yangon')->format('Y');
        $noon = Carbon::create($currentYear,$currentMonth,$currentDay,12,01,00,'Asia/Yangon');
        $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        $time =  Carbon::now('Asia/Yangon');
        $day = Carbon::now('Asia/Yangon')->format('l');

        $winNumberN = DthreeD::where('date',$date)->where('time','12:01 PM')->value('3D');
        $winNumberNoon = substr($winNumberN,1);

        $winNumberE = DthreeD::where('date',$date)->where('time','4:31 PM')->value('3D');
        $winNumberEven = substr($winNumberE,1);

        if ( $time->gt($noon) || $day == 'Sunday' || $day == 'Saturday'   )
        {   
            $winSlipNoon = [];
            $winSlipEven = [];
            $selectIntegersEven = BetInteger::where('integer', $winNumberEven)->get();
            $selectIntegers = BetInteger::where('integer',$winNumberNoon)->get();

            foreach( $selectIntegers as $selectInteger )
            {
                $checkSlip = BetSlip::where('id',$selectInteger['bet-slip-id'])->where('type','D2D')->where('status','ongoing')->first();
                
                if (!(empty($checkSlip)))

                {
                    if ( $checkSlip->forDate == $date || $checkSlip->forTime == '12:01 PM' )
                
                {   
                    
                    $winSlipNoon[] = [
                        'betslip' => $checkSlip,
                        'betinteger' => $selectInteger,
                        'user' => NormalUser::where('id',$checkSlip->userId)->first()
                    ];

                    $checkSlip->update([
                        'status' => 'win'
                    ]);

                    $win_user = NormalUser::where('id',$checkSlip->userId)->first();

                    $win_amount = $selectInteger->amount * 80;

                    $win_user->update([
                        'credits' => $win_user->credits + $win_amount
                    ]);
                }
            }

            }

            foreach( $selectIntegersEven as $selectIntegerEven )
            {
                $checkSlip = BetSlip::where('id',$selectIntegerEven['bet-slip-id'])->where('type','D2D')->where('status','ongoing')->first();
                if (!(empty($checkSlip)))
                {
                if ( $checkSlip->forDate == $date || $checkSlip->forTime == '4:31 PM')
                {
                    $winSlipEven[] = [
                        'betslip' => $checkSlip,
                        'betinteger' => $selectIntegerEven,
                        'user' => NormalUser::where('id',$checkSlip->userId)->first()
                    ];

                    $checkSlip->update([
                        'status' => 'win'
                    ]);

                    $win_user = NormalUser::where('id',$checkSlip->userId)->first();

                    $win_amount = $selectIntegerEven->amount * 80;

                    $win_user->update([
                        'credits' => $win_user->credits + $win_amount
                    ]);
                }
            }
            }
            return back()->with('message','D2D Compensation Success');
        }
        return back()->with('message','D2D Compensation Not Available!');
    }
    


        

    
    
    public function twodindex()
    {   
        $currentDay = Carbon::now('Asia/Yangon')->format('d');
        $currentMonth = Carbon::now('Asia/Yangon')->format('m');
        $currentYear = Carbon::now('Asia/Yangon')->format('Y');
        $noon = Carbon::create($currentYear,$currentMonth,$currentDay,12,01,00,'Asia/Yangon');
        $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        $time =  Carbon::now('Asia/Yangon');
        $day = Carbon::now('Asia/Yangon')->format('l');

        $winNumberN = DthreeD::where('date',$date)->where('time','12:01 PM')->value('3D');
        $winNumberNoon = substr($winNumberN,1);

        $winNumberE = DthreeD::where('date',$date)->where('time','4:31 PM')->value('3D');
        $winNumberEven = substr($winNumberE,1);

        if ( $time->gt($noon) || $day == 'Sunday' || $day == 'Saturday'   )
        {   
            $winSlipNoon = [];
            $winSlipEven = [];
            $selectIntegersEven = BetInteger::where('integer', $winNumberEven)->get();
            $selectIntegers = BetInteger::where('integer',$winNumberNoon)->get();

            foreach( $selectIntegers as $selectInteger )
            {
                $checkSlip = BetSlip::where('id',$selectInteger['bet-slip-id'])->where('type','D2D')->where('status','ongoing')->first();
                
                if (!(empty($checkSlip)))

                {
                    if ( $checkSlip->forDate == $date || $checkSlip->forTime == '12:01 PM' )
                
                {   
                    
                    $winSlipNoon[] = [
                        'betslip' => $checkSlip,
                        'betinteger' => $selectInteger,
                        'user' => NormalUser::where('id',$checkSlip->userId)->first()
                    ];
                }
            }

            }

            foreach( $selectIntegersEven as $selectIntegerEven )
            {
                $checkSlip = BetSlip::where('id',$selectIntegerEven['bet-slip-id'])->where('type','D2D')->where('status','ongoing')->first();
                if (!(empty($checkSlip)))
                {
                if ( $checkSlip->forDate == $date || $checkSlip->forTime == '4:31 PM')
                {
                    $winSlipEven[] = [
                        'betslip' => $checkSlip,
                        'betinteger' => $selectIntegerEven,
                        'user' => NormalUser::where('id',$checkSlip->userId)->first()
                    ];
                }
            }
            }

            return view('admin.compensate.twodview',[
                'winslips' => $winSlipNoon,
                'winslipsEven' => $winSlipEven,
                'winNumberNoon' => $winNumberNoon,
                'winNumberEven' => $winNumberEven
            ]);
        }

        return view('admin.compensate.twodview',[
            'winNumberNoon' => $winNumberNoon,
            'winNumberEven' => $winNumberEven,
            'winslipsEven' => [],
            'winslips' => []
        ]);
    }
    
}
