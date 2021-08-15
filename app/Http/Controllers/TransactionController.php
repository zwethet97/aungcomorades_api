<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\Bettors;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Transaction::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deposit(Request $request)
    {
        $fields = $request->validate([

            'userId' => 'required',
            'platform' => 'required',
            'accountnumber' => 'required',
            'amount' => 'required'
        ]);

        $deposit = Transaction::create([

            'userId' => $fields['userId'],
            'platform' => $fields['platform'],
            'accountnumber' => $fields['accountnumber'],
            'status' => 'deposit',
            'amount' => $fields['amount'],
            'transferuserId' => '-'
        ]);

        $changeamount = Bettors::find($fields['userId']);
        $existingamount = $changeamount->credits;
        $changeamount->update([
            'credits' => $existingamount + $fields['amount']
        ]);
        
        return response($deposit, 201);
    }

    public function withdraw(Request $request)
    {
        $fields = $request->validate([

            'userId' => 'required',
            'platform' => 'required',
            'accountnumber' => 'required',
            'amount' => 'required'
        ]);

        $changeamount = Bettors::find($fields['userId']);
        $existingamount = $changeamount->credits;

        if( $existingamount < $fields['amount']){
            return response([
                'message' => 'Not Enough Credits'
            ], 401);
        }

        $changeamount->update([
            'credits' => $existingamount - $fields['amount']
        ]);

        $withdraw = Transaction::create([

            'userId' => $fields['userId'],
            'platform' => $fields['platform'],
            'accountnumber' => $fields['accountnumber'],
            'status' => 'withdraw',
            'amount' => $fields['amount'],
            'transferuserId' => '-'
        ]);
        
        return response($withdraw, 201);
    }

    public function transfer(Request $request)
    {
        $fields = $request->validate([

            'userId' => 'required',
            'amount' => 'required',
            'transferuserId' => 'required'
        ]);

        $changeamount = Bettors::find($fields['userId']);
        $existingamount = $changeamount->credits;
        
        if( $existingamount < $fields['amount']){
            return response([
                'message' => 'Not Enough Credits'
            ], 401);
        }

        $changeamount->update([
            'credits' => $existingamount - $fields['amount']
        ]);
        
        $transferUser = Bettors::where('phone-number', $fields['transferuserId'])->first();

        if($transferUser->id == $fields['userId']){
            return response([
                'message' => "You can't transfer to your main account"
            ], 401);
        }

        $transferUserExistingamount = $transferUser->credits;
        $transferUser->update([
            'credits' => $transferUserExistingamount + $fields['amount']
        ]);

        $transfer = Transaction::create([

            'userId' => $fields['userId'],
            'platform' => '-',
            'accountnumber' => '-',
            'status' => 'transfer',
            'amount' => $fields['amount'],
            'transferuserId' => $fields['transferuserId']
        ]);

        return response($transfer, 201);
        
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       return Transaction::find($id);
        
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
        $transaction = Transacton::find($id);
        $transaction->update($request->all());
        return $transaction;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Transaction::destroy($id);
    }
}
