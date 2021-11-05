<?php

namespace App\Http\Controllers\Admin;

use App\Models\NormalUser;
use App\Models\BetSlip;
use App\Models\Transaction;
use App\Models\Referrals;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
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
        $todaysilver = NormalUser::where('user-level','silver')
                                ->whereDate('updated_at',Carbon::today())
                                ->count();

        return view('admin.users.index',[
            'users' => NormalUser::where('verified_otp',1)->paginate(3),
            'todayusers' => NormalUser::whereDate('created_at', Carbon::today())->count(),
            'todaysilver' => $todaysilver,
            'total' => NormalUser::where('verified_otp',1)->count()
        ]);
    }

    public function showUserBetslip($id){

        return view('admin.users.betslip',[
            'betslips' => BetSlip::where('userId',$id)->get(),
            'user' => NormalUser::where('id',$id)->first()
        ]);
    }
    public function showUserTransaction($id){

        return view('admin.users.transaction',[
            'transactions' => Transaction::where('userId',$id)->get(),
            'user' => NormalUser::where('id',$id)->first()
        ]);
    }
    public function showUserReferral($name){

        $referrals = Referrals::where('referral-code',$name)->get();

        $ref = [];
        foreach($referrals as $referral)
        {
            $ref[] = NormalUser::where('id',$referral['submitted-userId'])->first();
        }

        return view('admin.users.referral',[
            'referrals' => $ref,
            'user' => NormalUser::where('referral-code',$name)->first()
        ]);
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        NormalUser::insert([

        ]);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        NormalUser::destroy($id);

        return redirect(route('admin.users.index'));
    }
}
