<?php

namespace App\Http\Controllers;
use App\Models\PaymentInfo;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PaymentInfo::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'accountnumber' => 'required',
            'userId' => 'required'
        ]);

        return response([ 
            'success' => true,
            'message' => 'Data Created',
            'data' => PaymentInfo::all()
        ],201);    
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response([ 
            'success' => true,
            'message' => 'Data Found',
            'data' => PaymentInfo::find($id)
        ],200);  
        
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
        $payment = PaymentInfo::find($id);
        $payment->update($request->all());
        return response([ 
            'success' => true,
            'message' => 'Data Found',
            'data' => $payment
        ],200);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response([ 
            'success' => true,
            'message' => 'Data Deleted',
            'data' => PaymentInfo::destroy($id)
        ],203);  
    }
    public function search($name)
    { 
        return response([ 
            'success' => true,
            'message' => 'UserID Payment Found',
            'data' => PaymentInfo::where('userId', 'like', '%'.$name.'%')->get()
        ],203);  
    }
}
