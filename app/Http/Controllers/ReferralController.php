<?php

namespace App\Http\Controllers;
use App\Models\Referrals;
use Illuminate\Http\Response;
use App\Models\Bettors;

use Illuminate\Http\Request;

class ReferralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Referrals::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([

            'referral-code' => 'required|string',
            'submitted-userId' => 'required|string|unique:referrals,submitted-userId'
        ]);

        $checkreferral = Bettors::where('referral-code', $fields['referral-code'])->first();
        $checksubmitted = Bettors::where('id', $fields['submitted-userId'])->value('referral-code');

        if( !$checkreferral || $checksubmitted == $fields['referral-code'] ){
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        
        $referral = Referrals::create([
            'referral-code' => $fields['referral-code'],
            'submitted-userId' => $fields['submitted-userId']
        ]);



        return response($referral, 201);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
