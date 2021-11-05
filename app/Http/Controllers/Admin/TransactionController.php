<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\NormalUser;

class TransactionController extends Controller
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
        return view('admin.transaction.index',[
            'transactions' => Transaction::where('status','=','deposit')->orWhere('status','=','withdraw')->orWhere('status','=','transferIn')
                                        ->orWhere('status','=','transferOut')
                                        ->orderBy('created_at','ASC')->get()

        ]);
    }

    public function deposit()
    {   

        $deposit = [];
        $depos = Transaction::where('status','deposit_req')->get();

        foreach ( $depos as $depo ){
            $deposit[] = [
                'user' => NormalUser::where('id',$depo->userId)->first(),
                'depo' => $depo
            ];
        }
        return view('admin.transaction.deposit',[
            'deposits' => $deposit
        ]);
    }

    public function depoUpdate(Request $request,$id)
    {
        $depoId = Transaction::find($id);
        $user = NormalUser::where('id',$depoId->userId)->first();

        $depoId->update([
            'status' => 'deposit'
        ]);

        $user->update([
            'credits' => $user->credits + $request['amount']
        ]);

        return redirect(route('transaction.deposit'))->with('message','Successfully Deposit!');
    }

    public function withdraw()
    {   

        $withdraw = [];
        $withdrawls = Transaction::where('status','withdraw_req')->get();

        foreach ( $withdrawls as $withdrawl ){
            $withdraw[] = [
                'user' => NormalUser::where('id',$withdrawl->userId)->first(),
                'withdrawl' => $withdrawl
            ];
        }
        return view('admin.transaction.withdraw',[
            'withdraws' => $withdraw
        ]);
    }

    public function withdrawUpdate(Request $request,$id)
    {
        $withdrawId = Transaction::find($id);
        $user = NormalUser::where('id',$withdrawId->userId)->first();


        if ( $user->credits < $request['amount'] )
        {
            return redirect(route('transaction.withdraw'))->withErrors(['message' => 'Not enought credits to withdrawl!']);
        }

        $withdrawId->update([
            'status' => 'withdraw'
        ]);


        $user->update([
            'credits' => $user->credits - $request['amount']
        ]);

        return redirect(route('transaction.withdraw'))->with('message',"Successfully Withdrawl!");
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
