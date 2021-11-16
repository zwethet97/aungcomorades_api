<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\NormalUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Noti;
use App\Models\Rewards;


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
            'status' => 'deposit_req',
            'amount' => $fields['amount'],
            'transferuserId' => '-',
            'screen-shot' => $imageName
        ]);

        

        $changeamount = NormalUser::find($fields['userId']);
        $existingamount = $changeamount->credits;
        // $changeamount->update([
        //     'credits' => $existingamount + $fields['amount']
        // ]);
        $token = "_tGnrDluQo1JOqyLaILa-fTlozduLX5fW-JvtdDT4xW4OE2bDC_67DeBTYAe9fhl";

        // Prepare data for POST request
        $data = [
            "to"        =>      "09777870090",
            "message"   =>      $fields['amount']."Credits. Deposit request receive from".$fields['platform']." ".$fields['accountnumber']."(".$changeamount['phone-number'].")",
            "sender"    =>      "Aung Pwal"
        ];
        
        
        $ch = curl_init("https://smspoh.com/api/v2/send");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json'
            ]);
        
        $result = curl_exec($ch);

        Noti::insert([
            'description' => 'Your Deposit Request is currently is on progress. Please wait for Admin Response',
            'userId' => $fields['userId'],
            'type' => 'transaction',
            'typeid' => $deposit->id
        ]);

        return response([ 
            'success' => true,
            'message' => 'Deposit Request Successfully! Alert Admin for Credits',
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
            ], 200);
        }

        $changeamount->update([
            'credits' => $existingamount - $fields['amount']
        ]);

        $withdraw = Transaction::create([

            'userId' => $fields['userId'],
            'platform' => $fields['platform'],
            'accountnumber' => $fields['accountnumber'],
            'status' => 'withdraw_req',
            'amount' => $fields['amount'],
            'transferuserId' => '-',
            'screen-shot' => '-'
        ]);

        Noti::insert([
            'description' => 'Your Withdraw Request is currently is on progress. Please wait for Admin Response',
            'userId' => $fields['userId'],
            'type' => 'transaction',
            'typeid' => $withdraw->id
        ]);
        
        $changeamount = NormalUser::find($fields['userId']);

        $token = "_tGnrDluQo1JOqyLaILa-fTlozduLX5fW-JvtdDT4xW4OE2bDC_67DeBTYAe9fhl";

        // Prepare data for POST request
        $data = [
            "to"        =>      "09777870090",
            "message"   =>      $fields['amount']."Credits. Withdraw request receive from".$fields['platform']." ".$fields['accountnumber']."(".$changeamount['phone-number'].")",
            "sender"    =>      "Aung Pwal"
        ];
        
        
        $ch = curl_init("https://smspoh.com/api/v2/send");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json'
            ]);
        
        $result = curl_exec($ch);

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
            ], 200);
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
            ], 200);
        }
       
        $transferUserExistingamount = $transferUser->credits;
        $transferUser->update([
            'credits' => $transferUserExistingamount + $fields['amount']
        ]);

        $transfer = Transaction::create([

            'userId' => $fields['userId'],
            'platform' => '-',
            'accountnumber' => '-',
            'status' => 'transferout',
            'amount' => $fields['amount'],
            'transferuserId' => $fields['transferuserId'],
            'screen-shot' => '-'
        ]);

        $transferin = Transaction::create([

            'userId' => $transferUser->id,
            'platform' => '-',
            'accountnumber' => '-',
            'status' => 'transferin',
            'amount' => $fields['amount'],
            'transferuserId' => $changeamount['phone-number'],
            'screen-shot' => '-'
        ]);

        Noti::insert([
            'description' => 'You receive '.$fields['amount'].' from '.$changeamount['phone-number'],
            'userId' => $transferUser->id,
            'type' => 'transaction',
            'typeid' => $transferin->id
        ]);

        Noti::insert([
            'description' => 'Amount '.$fields['amount'].'is successfully to transfer to '.$fields['transferuserId'],
            'userId' => $fields['userId'],
            'type' => 'transaction',
            'typeid' => $transfer->id
        ]);

        return response([ 
            'success' => true,
            'message' => 'Transfer Successfully',
            'data' => $transfer
        ], 201);    
    }

    public function upgrade($id) {

        $userId = NormalUser::where('id',$id)->first();
        $existingCredit = $userId->credits;
        
        if ($userId['user-level'] != 'free')
        {  
            return response([ 
                'success' => false,
                'message' => 'User is already upgraded',
                'data' => []
            ], 200);

        }

        if ( $userId['credits'] < 10000 )
        {  
            return response([ 
                'success' => false,
                'message' => 'Not Enought Credits to upgrade',
                'data' => []
            ], 200);

        }

        $update = $userId->update([
            'user-level' => 'silver',
            'credits' => $existingCredit - 10000
        ]);

        return response([ 
            'success' => true,
            'message' => 'User Level Upgraded to SILVER',
            'data' => $userId
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
        $data = [
            'transactions' => Transaction::where('userId', 'like', '%'.$name.'%')
                                    ->whereNotIn('status', ['deposit_req','withdraw_req'])
                                    ->orderBy('created_at','desc')
                                    ->get(),
            'reward' => Rewards::where('userId',$name)->get()
            ];
        return response([ 
            'success' => true,
            'message' => 'Data Found',
            'data' => $data
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
