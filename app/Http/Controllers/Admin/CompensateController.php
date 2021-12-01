<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BetSlip;
use App\Models\BetInteger;
use App\Models\BetLimit;
use App\Models\DthreeD;
use App\Models\User;
use App\Models\Internet;
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

    public function winNumber()
    {
        $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        $limit = BetLimit::all();

        $numberNoon = DthreeD::where('date',$date)->get();
        $internet = Internet::where('date',$date)->get();


        return view('admin.compensate.number',[
            'noons' => $numberNoon,
            'limits' => $limit,
            'internets' => $internet
        ]);

    }

    public function winUpdate(Request $request,$id)
    {   
        $request->validate([
            'password' => 'required' 
         ]);
 
         $admin = User::where('id','1')->first();
         
         if (!Hash::check($request->password,$admin->password))
         {
             return back()->with('message','Password is not correct');
         }

        $no = DthreeD::where('id',$id)->first();

        $no->update([
            '3D' => $request->d3d,
            'plustwod' => $request->pluswtwod,
            'set' => $request->set,
            'value' => $request->value
        ]);

        return back()->with('message','Changed Number!');
    }

    public function winInternetUpdate(Request $request,$id)
    {   
        $request->validate([
            'password' => 'required' 
         ]);
 
         $admin = User::where('id','1')->first();
         
         if (!Hash::check($request->password,$admin->password))
         {
             return back()->with('message','Password is not correct');
         }

        $no = Internet::where('id',$id)->first();

        $no->update([
            'internet' => $request->internet
        ]);

        return back()->with('message','Changed Number!');
    }

    public function limitUpdate(Request $request,$id)
    {   
        $request->validate([
            'password' => 'required' 
         ]);
 
        $admin = User::where('id','1')->first();
        
        $limit = BetLimit::where('id',$id)->first();

        $limit->update([
            'limit' => $request->limit
        ]);

        return back()->with('message','Limit Updated!');
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

            if ( $winNumberNoon )

            {
                foreach( $selectIntegers as $selectInteger )
            {
                $checkSlip = BetSlip::where('id',$selectInteger['bet-slip-id'])->where('forTime','12:01 PM')->where('forDate',$date)->where('type','D3D')->where('status','ongoing')->first();
                
                if (!(empty($checkSlip)))

                {
                
                    $winSlipNoon[] = [
                        'betslip' => $checkSlip,
                        'betinteger' => $selectInteger,
                        'user' => NormalUser::where('id',$checkSlip->userId)->first()
                    ];
                
            }
            }
            }

            if ( $winNumberEven )
            {
                foreach( $selectIntegersEven as $selectIntegerEven )
            {
                $checkSlip = BetSlip::where('id',$selectIntegerEven['bet-slip-id'])->where('forTime','4:30 PM')->where('forDate',$date)->where('status','ongoing')->first();
                if (!(empty($checkSlip)))
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
        $winNumberNoon1 = [];
        $winNumberNoon2 = [];
        $winNumberNoon3 = [];
        $winNumberNoon4 = [];
        $winNumberNoon5 = [];
        $winNumberNoon6 = [];
        $winNumberNoon7 = [];
        $winNumberEven1 = [];
        $winNumberEven2 = [];
        $winNumberEven3 = [];
        $winNumberEven4 = [];
        $winNumberEven5 = [];
        $winNumberEven6 = [];
        $winNumberEven7 = [];
        
        if ( $time->gt($noon) || !$time->isWeekend() )
        {   
            $winSlipNoon = [];
            $winSlipEven = [];
            
            if ( $winNumberNoon )
            {   
                $winNumberNoon1 = $winNumberNoon + 1;
                $winNumberNoon2 = $winNumberNoon - 1;
                $winNumberNoon3 = $winNumberNoon[1].$winNumberNoon[2].$winNumberNoon[0];
                $winNumberNoon4 = $winNumberNoon[1].$winNumberNoon[0].$winNumberNoon[2];
                $winNumberNoon5 = $winNumberNoon[2].$winNumberNoon[0].$winNumberNoon[1];
                $winNumberNoon6 = $winNumberNoon[2].$winNumberNoon[1].$winNumberNoon[0];
                $winNumberNoon7 = $winNumberNoon[0].$winNumberNoon[2].$winNumberNoon[1];

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
                $checkSlip = BetSlip::where('id',$selectInteger['bet-slip-id'])->where('forTime','12:01 PM')->where('forDate',$date)->where('type','D3D')->where('status','ongoing')->first();
                
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
                    $winNumberEven1 = $winNumberEven + 1;
                    $winNumberEven2 = $winNumberEven - 1;
                    $winNumberEven3 = $winNumberEven[1].$winNumberEven[2].$winNumberEven[0];
                    $winNumberEven4 = $winNumberEven[1].$winNumberEven[0].$winNumberEven[2];
                    $winNumberEven5 = $winNumberEven[2].$winNumberEven[0].$winNumberEven[1];
                    $winNumberEven6 = $winNumberEven[2].$winNumberEven[1].$winNumberEven[0];
                    $winNumberEven7 = $winNumberEven[0].$winNumberEven[2].$winNumberEven[1];
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
                $checkSlip = BetSlip::where('id',$selectIntegerEven['bet-slip-id'])->where('forTime','4:30 PM')->where('forDate',$date)->where('status','ongoing')->first();
                if (!(empty($checkSlip)))
                {
                if ( $checkSlip->forDate == $date || $checkSlip->forTime == '4:30 PM')
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
                'winNumberNoon1' => $winNumberNoon1,
                'winNumberNoon2' => $winNumberNoon2,
                'winNumberNoon3' => $winNumberNoon3,
                'winNumberNoon4' => $winNumberNoon4,
                'winNumberNoon5' => $winNumberNoon5,
                'winNumberNoon6' => $winNumberNoon6,
                'winNumberNoon7' => $winNumberNoon7,
                'winNumberEven1' => $winNumberEven1,
                'winNumberEven2' => $winNumberEven2,
                'winNumberEven3' => $winNumberEven3,
                'winNumberEven4' => $winNumberEven4,
                'winNumberEven5' => $winNumberEven5,
                'winNumberEven6' => $winNumberEven6,
                'winNumberEven7' => $winNumberEven7,
                'winNumberEven' => $winNumberEven
            ]);
        }

        return view('admin.compensate.round',[
            'winNumberNoon' => $winNumberNoon,
            'winNumberNoon1' => $winNumberNoon1,
            'winNumberNoon2' => $winNumberNoon2,
            'winNumberNoon3' => $winNumberNoon3,
            'winNumberNoon4' => $winNumberNoon4,
            'winNumberNoon5' => $winNumberNoon5,
            'winNumberNoon6' => $winNumberNoon6,
            'winNumberNoon7' => $winNumberNoon7,
            'winNumberEven1' => $winNumberEven1,
            'winNumberEven2' => $winNumberEven2,
            'winNumberEven3' => $winNumberEven3,
            'winNumberEven4' => $winNumberEven4,
            'winNumberEven5' => $winNumberEven5,
            'winNumberEven6' => $winNumberEven6,
            'winNumberEven7' => $winNumberEven7,
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
                $checkSlip = BetSlip::where('id',$selectInteger['bet-slip-id'])->where('forTime','12:01 PM')->where('forDate',$date)->where('type','D3D')->where('status','ongoing')->first();
                
                if (!(empty($checkSlip)))

                {
                    if ( $checkSlip->forDate == $date || $checkSlip->forTime == '12:01 PM' )
                
                {    
                
                    $checkSlip->update([
                        'status' => 'win',
                        'win_number' => $winNumberNoon
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
                $checkSlip = BetSlip::where('id',$selectIntegerEven['bet-slip-id'])->where('forTime','4:30 PM')->where('forDate',$date)->where('status','ongoing')->first();
                if (!(empty($checkSlip)))
                {
                if ( $checkSlip->forDate == $date || $checkSlip->forTime == '4:30 PM')
                {
                    
                    $checkSlip->update([
                        'status' => 'win',
                        'win_number' => $winNumberEven
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

            if ($winNumberNoon)
            {
                foreach( $selectIntegers as $selectInteger )
                {
                    $checkSlip = BetSlip::where('id',$selectInteger['bet-slip-id'])->where('forTime','12:01 PM')->where('forDate',$date)->where('type','D3D')->where('status','ongoing')->first();
                    
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
                            'status' => 'win',
                            'win_number' => $winNumberNoon
                        ]);

                        $win_user = NormalUser::where('id',$checkSlip->userId)->first();

                        $win_amount = $selectInteger->amount * 600;

                        $win_user->update([
                            'credits' => $win_user->credits + $win_amount
                        ]);
                    }
                }

                }
            }

            if ( $winNumberEven )
            {
                foreach( $selectIntegersEven as $selectIntegerEven )
                {
                    $checkSlip = BetSlip::where('id',$selectIntegerEven['bet-slip-id'])->where('forTime','4:30 PM')->where('forDate',$date)->where('status','ongoing')->first();
                    if (!(empty($checkSlip)))
                    {
                    if ( $checkSlip->forDate == $date || $checkSlip->forTime == '4:30 PM')
                    {
                        $winSlipEven[] = [
                            'betslip' => $checkSlip,
                            'betinteger' => $selectIntegerEven,
                            'user' => NormalUser::where('id',$checkSlip->userId)->first()
                        ];

                        $checkSlip->update([
                            'status' => 'win',
                            'win_number' => $winNumberEven
                        ]);

                        $win_user = NormalUser::where('id',$checkSlip->userId)->first();

                        $win_amount = $selectIntegerEven->amount * 600;

                        $win_user->update([
                            'credits' => $win_user->credits + $win_amount
                        ]);
                    }
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
                $checkSlip = BetSlip::where('id',$selectInteger['bet-slip-id'])->where('forTime','12:01 PM')->where('forDate',$date)->where('type','D2D')->where('status','ongoing')->first();
                
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
                        'status' => 'win',
                        'win_number' => $winNumberNoon
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
                $checkSlip = BetSlip::where('id',$selectIntegerEven['bet-slip-id'])->where('forTime','4:30 PM')->where('forDate',$date)->where('type','D2D')->where('status','ongoing')->first();
                if (!(empty($checkSlip)))
                {
                if ( $checkSlip->forDate == $date || $checkSlip->forTime == '4:30 PM')
                {
                    $winSlipEven[] = [
                        'betslip' => $checkSlip,
                        'betinteger' => $selectIntegerEven,
                        'user' => NormalUser::where('id',$checkSlip->userId)->first()
                    ];

                    $checkSlip->update([
                        'status' => 'win',
                        'win_number' => $winNumberEven
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
            

            if ( $winNumberN )
            {
                foreach( $selectIntegers as $selectInteger )
                {
                    $checkSlip = BetSlip::where('id',$selectInteger['bet-slip-id'])->where('forTime','12:01 PM')->where('forDate',$date)->where('type','D2D')->where('status','ongoing')->first();
                    
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
            if ( $winNumberE )
            {
                foreach( $selectIntegersEven as $selectIntegerEven )
                {

                    $checkSlip = BetSlip::where('id',$selectIntegerEven['bet-slip-id'])->where('forTime','4:30 PM')->where('forDate',$date)->where('type','D2D')->where('status','ongoing')->first();
                    if (!(empty($checkSlip)))
                    {
                    if ( $checkSlip->forDate == $date || $checkSlip->forTime == '4:30 PM')
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

    public function plusTwodindex()
    {   
        $currentDay = Carbon::now('Asia/Yangon')->format('d');
        $currentMonth = Carbon::now('Asia/Yangon')->format('m');
        $currentYear = Carbon::now('Asia/Yangon')->format('Y');
        $noon = Carbon::create($currentYear,$currentMonth,$currentDay,12,01,00,'Asia/Yangon');
        $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        $time =  Carbon::now('Asia/Yangon');
        $day = Carbon::now('Asia/Yangon')->format('l');

        $winNumberNoon = DthreeD::where('date',$date)->where('time','12:01 PM')->value('plustwod');
        $winNumberEven = DthreeD::where('date',$date)->where('time','4:31 PM')->value('plustwod');

        if ( $time->gt($noon) || $day == 'Sunday' || $day == 'Saturday'   )
        {   
            $winSlipNoon = [];
            $winSlipEven = [];
            $selectIntegersEven = BetInteger::where('integer', $winNumberEven)->get();
            $selectIntegers = BetInteger::where('integer',$winNumberNoon)->get();
            

            if ( $winNumberNoon )
            {
                foreach( $selectIntegers as $selectInteger )
                {
                    $checkSlip = BetSlip::where('id',$selectInteger['bet-slip-id'])->where('forTime','12:01 PM')->where('forDate',$date)->where('type','2DPLUS')->where('status','ongoing')->first();
                    
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
            if ( $winNumberEven )
            {
                foreach( $selectIntegersEven as $selectIntegerEven )
                {

                    $checkSlip = BetSlip::where('id',$selectIntegerEven['bet-slip-id'])->where('forTime','4:30 PM')->where('forDate',$date)->where('type','2DPLUS')->where('status','ongoing')->first();
                    if (!(empty($checkSlip)))
                    {
                    if ( $checkSlip->forDate == $date || $checkSlip->forTime == '4:30 PM')
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

            return view('admin.compensate.plusview',[
                'winslips' => $winSlipNoon,
                'winslipsEven' => $winSlipEven,
                'winNumberNoon' => $winNumberNoon,
                'winNumberEven' => $winNumberEven
            ]);
        }

        return view('admin.compensate.plusview',[
            'winNumberNoon' => $winNumberNoon,
            'winNumberEven' => $winNumberEven,
            'winslipsEven' => [],
            'winslips' => []
        ]);
    }

    public function compensatePlusTwod(Request $request){
        
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

        $winNumberNoon = DthreeD::where('date',$date)->where('time','12:01 PM')->value('plustwod');

        $winNumberEven = DthreeD::where('date',$date)->where('time','4:31 PM')->value('plustwod');
        

        if ( $time->gt($noon) || $day == 'Sunday' || $day == 'Saturday'   )
        {   
            $winSlipNoon = [];
            $winSlipEven = [];
            $selectIntegersEven = BetInteger::where('integer', $winNumberEven)->get();
            $selectIntegers = BetInteger::where('integer',$winNumberNoon)->get();

            foreach( $selectIntegers as $selectInteger )
            {
                $checkSlip = BetSlip::where('id',$selectInteger['bet-slip-id'])->where('forTime','12:01 PM')->where('forDate',$date)->where('type','2DPLUS')->where('status','ongoing')->first();
                
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
                        'status' => 'win',
                        'win_number' => $winNumberNoon
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
                $checkSlip = BetSlip::where('id',$selectIntegerEven['bet-slip-id'])->where('forTime','4:30 PM')->where('forDate',$date)->where('type','2DPLUS')->where('status','ongoing')->first();
                if (!(empty($checkSlip)))
                {
                if ( $checkSlip->forDate == $date || $checkSlip->forTime == '4:30 PM')
                {
                    $winSlipEven[] = [
                        'betslip' => $checkSlip,
                        'betinteger' => $selectIntegerEven,
                        'user' => NormalUser::where('id',$checkSlip->userId)->first()
                    ];

                    $checkSlip->update([
                        'status' => 'win',
                        'win_number' => $winNumberEven
                    ]);

                    $win_user = NormalUser::where('id',$checkSlip->userId)->first();

                    $win_amount = $selectIntegerEven->amount * 85;

                    $win_user->update([
                        'credits' => $win_user->credits + $win_amount
                    ]);
                }
            }
            }
            return back()->with('message','2Dplus Compensation Success');
        }
        return back()->with('message','2Dplus Compensation Not Available!');
    }

    public function compensateInternet(Request $request){
        
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
        $noon = Carbon::create($currentYear,$currentMonth,$currentDay,9,31,00,'Asia/Yangon');
        $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        $time =  Carbon::now('Asia/Yangon');
        $day = Carbon::now('Asia/Yangon')->format('l');

        $winNumberNoon = Internet::where('date',$date)->where('time','9:00 AM')->value('internet');

        $winNumberEven = Internet::where('date',$date)->where('time','2:00 PM')->value('internet');
        

        if ( $time->gt($noon) || $day == 'Sunday' || $day == 'Saturday'   )
        {   
            $winSlipNoon = [];
            $winSlipEven = [];
            $selectIntegersEven = BetInteger::where('integer', $winNumberEven)->get();
            $selectIntegers = BetInteger::where('integer',$winNumberNoon)->get();

            foreach( $selectIntegers as $selectInteger )
            {
                $checkSlip = BetSlip::where('id',$selectInteger['bet-slip-id'])->where('forTime','9:30 AM')->where('forDate',$date)->where('type','INTERNET')->where('status','ongoing')->first();
                
                if (!(empty($checkSlip)))

                {
                    if ( $checkSlip->forDate == $date || $checkSlip->forTime == '9:30 AM' )
                
                {   
                    
                    $winSlipNoon[] = [
                        'betslip' => $checkSlip,
                        'betinteger' => $selectInteger,
                        'user' => NormalUser::where('id',$checkSlip->userId)->first()
                    ];

                    $checkSlip->update([
                        'status' => 'win',
                        'win_number' => $winNumberNoon
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
                $checkSlip = BetSlip::where('id',$selectIntegerEven['bet-slip-id'])->where('forTime','2:00 PM')->where('forDate',$date)->where('type','INTERNET')->where('status','ongoing')->first();
                if (!(empty($checkSlip)))
                {
                if ( $checkSlip->forDate == $date || $checkSlip->forTime == '4:30 PM')
                {
                    $winSlipEven[] = [
                        'betslip' => $checkSlip,
                        'betinteger' => $selectIntegerEven,
                        'user' => NormalUser::where('id',$checkSlip->userId)->first()
                    ];

                    $checkSlip->update([
                        'status' => 'win',
                        'win_number' => $winNumberEven
                    ]);

                    $win_user = NormalUser::where('id',$checkSlip->userId)->first();

                    $win_amount = $selectIntegerEven->amount * 85;

                    $win_user->update([
                        'credits' => $win_user->credits + $win_amount
                    ]);
                }
            }
            }
            return back()->with('message','Internet Compensation Success');
        }
        return back()->with('message','Internet Compensation Not Available!');
    }

    public function internetIndex()
    {   
        $currentDay = Carbon::now('Asia/Yangon')->format('d');
        $currentMonth = Carbon::now('Asia/Yangon')->format('m');
        $currentYear = Carbon::now('Asia/Yangon')->format('Y');
        $noon = Carbon::create($currentYear,$currentMonth,$currentDay,9,30,00,'Asia/Yangon');
        $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        $time =  Carbon::now('Asia/Yangon');
        $day = Carbon::now('Asia/Yangon')->format('l');

        $winNumberNoon = Internet::where('date',$date)->where('time','9:30 AM')->value('internet');
        $winNumberEven = Internet::where('date',$date)->where('time','2:00 PM')->value('internet');

        if ( $time->gt($noon) || $day == 'Sunday' || $day == 'Saturday'   )
        {   
            $winSlipNoon = [];
            $winSlipEven = [];
            $selectIntegersEven = BetInteger::where('integer', $winNumberEven)->get();
            $selectIntegers = BetInteger::where('integer',$winNumberNoon)->get();
            

            if ( $winNumberNoon )
            {
                foreach( $selectIntegers as $selectInteger )
                {
                    $checkSlip = BetSlip::where('id',$selectInteger['bet-slip-id'])->where('forTime','9:30 AM')->where('forDate',$date)->where('type','INTERNET')->where('status','ongoing')->first();
                    
                    if (!(empty($checkSlip)))

                    {
                        if ( $checkSlip->forDate == $date || $checkSlip->forTime == '9:30 AM' )
                    
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
            if ( $winNumberEven )
            {
                foreach( $selectIntegersEven as $selectIntegerEven )
                {

                    $checkSlip = BetSlip::where('id',$selectIntegerEven['bet-slip-id'])->where('forTime','2:00 PM')->where('forDate',$date)->where('type','INTERNET')->where('status','ongoing')->first();
                    if (!(empty($checkSlip)))
                    {
                    if ( $checkSlip->forDate == $date || $checkSlip->forTime == '2:00 PM')
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

            return view('admin.compensate.internet',[
                'winslips' => $winSlipNoon,
                'winslipsEven' => $winSlipEven,
                'winNumberNoon' => $winNumberNoon,
                'winNumberEven' => $winNumberEven
            ]);
        }

        return view('admin.compensate.internet',[
            'winNumberNoon' => $winNumberNoon,
            'winNumberEven' => $winNumberEven,
            'winslipsEven' => [],
            'winslips' => []
        ]);
    }
    
}
