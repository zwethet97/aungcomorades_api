<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\NormalUser;
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
            'amount' => 'required',
            'screenshot' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $imageName = time().'.'.$request->screenshot->extension();  
     
        $request->screenshot->move(public_path('screenShotImages'), $imageName);

        $deposit = Transaction::create([

            'userId' => $fields['userId'],
            'platform' => $fields['platform'],
            'accountnumber' => $fields['accountnumber'],
            'status' => 'deposit',
            'amount' => $fields['amount'],
            'transferuserId' => '-',
            'screen-shot' => $imageName
        ]);

        $changeamount = NormalUser::find($fields['userId']);
        $existingamount = $changeamount->credits;
        $changeamount->update([
            'credits' => $existingamount + $fields['amount']
        ]);
        
        return response([ 
            'success' => true,
            'message' => 'Deposit Successfully! Alert Admin for Credits',
            'data' => $deposit
        ], 201);
    }

    public function withdraw(Request $request)
    {
        $fields = $request->validate([

            'userId' => 'required',
            'platform' => 'required',
            'accountnumber' => 'required',
            'amount' => 'required'
        ]);

        $changeamount = NormalUser::find($fields['userId']);
        $existingamount = $changeamount->credits;

        if( $existingamount < $fields['amount']){
            return response([
                'success' => false,
                'message' => 'Not Enough Credits',
                'data' => []
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
            'transferuserId' => '-',
            'screen-shot' => '-'
        ]);
        
        return response([ 
            'success' => true,
            'message' => 'Withdrawl Successfully',
            'data' => $withdraw
        ], 201);
    }

    public function transfer(Request $request)
    {
        $fields = $request->validate([

            'userId' => 'required',
            'amount' => 'required',
            'transferuserId' => 'required'
        ]);

        $changeamount = NormalUser::find($fields['userId']);
        $existingamount = $changeamount->credits;
        
        if( $existingamount < $fields['amount']){
            return response([
                'success' => false,
                'message' => 'Not Enough Credits',
                'data' => []
            ], 401);
        }

        $changeamount->update([
            'credits' => $existingamount - $fields['amount']
        ]);
        
        $transferUser = NormalUser::where('phone-number', $fields['transferuserId'])->first();

        if($transferUser->id == $fields['userId']){
            return response([
                'success' => false,
                'message' => "You can't transfer to your account",
                'data' => []
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
            'transferuserId' => $fields['transferuserId'],
            'screen-shot' => '-'
        ]);

        return response([ 
            'success' => true,
            'message' => 'Transfer Successfully',
            'data' => $transfer
        ], 201);    
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
    public function search($name)
    {
        return response([ 
            'success' => true,
            'message' => 'Data Found',
            'data' => Transaction::where('userId', 'like', '%'.$name.'%')->get()
        ], 200);
    }
    public function searchtransferUserPhone($name)
    {
        return response([ 
            'success' => true,
            'message' => 'Data Found',
            'data' => Transaction::where('transferuserId', 'like', '%'.$name.'%')->get()
        ], 200);
    }
}
