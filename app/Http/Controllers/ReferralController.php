<?php

namespace App\Http\Controllers;
use App\Models\Referrals;
use Illuminate\Http\Response;
use App\Models\NormalUser;

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
        return response([
            'success' => true,
            'message' => 'Data Found',
            'data' => Referrals::all()
        ],200);
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

        $checkreferral = NormalUser::where('referral-code', $fields['referral-code'])->first();
        $checksubmitted = NormalUser::where('id', $fields['submitted-userId'])->value('referral-code');
        $referralrole = NormalUser::where('referral-code', $fields['referral-code'])->value('user-level');

        
        $checksubmitted_user = NormalUser::where('id', $fields['submitted-userId'])->first();
        
        $checksubmitted_referrals = Referrals::where('referral-code',$checksubmitted_user['referral-code'])->get();
        
        foreach($checksubmitted_referrals as $check){
            
            $old_submit = NormalUser::where('id',$check['submitted-userId'])->first();
            
            if ($old_submit['referral-code'] == $fields['referral-code'])
            {
                return response([
                'success'  => false,
                'message' => "You can't submit your own referrals.",
                'data' => ''
            ], 201);
                
            }
        }

        if( !$checkreferral || $checksubmitted == $fields['referral-code'] ){
            return response([
                'success'  => false,
                'message' => "Referrals already exist or you can't submit your own referral code",
                'data' => ''
            ], 201);
        }
        
                
        $referral = Referrals::create([
            'referral-code' => $fields['referral-code'],
            'submitted-userId' => $fields['submitted-userId']
        ]);
        
        $referralrolecount = Referrals::where('referral-code', $fields['referral-code'])->count();
        

        if ( $referralrole == 'silver' )
        {   
            $count = 0;
            $referral_crs = Referrals::where('referral-code',$fields['referral-code'])->get();

            foreach($referral_crs as $referral_cr)
            {
                if(NormalUser::where('id', $referral_cr['submitted-userId'])->where('user-level','!=','free')->first())
                {
                    $count += 1;
                }
            }

            if ($count >= 10 )
            {
                $checkreferral->update([
                    'user-level' => 'gold'
                ]);
            }
        }

        if ( $referralrole == 'gold' )
        {   
            $count = 0;
            $referral_crs = Referrals::where('referral-code',$fields['referral-code'])->get();

            foreach($referral_crs as $referral_cr)
            {
                if(NormalUser::where('id', $referral_cr['submitted-userId'])->where('user-level','!=','free')->first())
                {
                    $count += 1;
                }
            }

            if ($count >= 30 )
            {
                $checkreferral->update([
                    'user-level' => 'diamond'
                ]);
            }
        }

        if ( $referralrole == 'diamond' )
        {   
            $count = 0;
            $referral_crs = Referrals::where('referral-code',$fields['referral-code'])->get();

            foreach($referral_crs as $referral_cr)
            {
                if(NormalUser::where('id', $referral_cr['submitted-userId'])->where('user-level','!=','free')->first())
                {
                    $count += 1;
                }
            }

            if ($count >= 50 )
            {
                $checkreferral->update([
                    'user-level' => 'jade'
                ]);
            }
        }

        if ( $referralrole == 'jade' )
        {   
            $count = 0;
            $referral_crs = Referrals::where('referral-code',$fields['referral-code'])->get();

            foreach($referral_crs as $referral_cr)
            {
                if(NormalUser::where('id', $referral_cr['submitted-userId'])->where('user-level','!=','free')->first())
                {
                    $count += 1;
                }
            }

            if ($count >= 100 )
            {
                $checkreferral->update([
                    'user-level' => 'ruby'
                ]);
            }
        }

        return response([
            'success' => true,
            'message' => 'Data Created',
            'data' => $referral
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function check_submit($submitid)
    {
        $submituser = Referrals::where('submitted-userId',$submitid)->first();
        
        if (!$submituser)
        {
            return response([
                'success' => false,
                'message' => 'Data Not Found',
                'data' => []
            ],200);
        }
        return response([
            'success' => true,
            'message' => 'Data Found',
            'data' => $submituser
        ],200);

    }
    public function show($code)
    {
        $submitted = [];
        
        $Susers = Referrals::where('referral-code','like', '%'.$code.'%')->get();

        foreach($Susers as $Suser)
        {   
            $user = NormalUser::where('id',$Suser['submitted-userId'])->first();
            $submitted[] = $user;
        }
        return response([
            'success' => true,
            'message' => 'Submitted User List',
            'data' => $submitted
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
    public function search($name)
    {   
        if (!NormalUser::where('referral-code', 'like', '%'.$name.'%')->first()) 
        {
            return response([
                'success' => false,
                'message' => 'Date Not Found',
                'data' => []
            ],200);
        }
        

        return response([
            'success' => true,
            'message' => 'Data Found',
            'data' => NormalUser::where('referral-code', 'like', '%'.$name.'%')->get()
        ],200);
    }
    public function checkSubmit($id)
    {
        if (Referrals::where('submitted-userId',$id)->first())
        {
            return response([
                'success' => false,
                'message' => 'Already submitted Referral',
                'data' => []
            ],200);
        }
        
        return response([
                'success' => true,
                'message' => 'You can submit',
                'data' => []
            ],200);
    }
}
