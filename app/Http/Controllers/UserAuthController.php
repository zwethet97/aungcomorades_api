<?php

namespace App\Http\Controllers;

use App\Models\NormalUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return NormalUser::all();
    }

    public function generateRandomString($length = 20) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $fields = $request->validate([

            'username' => 'required|string',
            'phone-number' => 'required|string',
            'password' => 'required|string'

        ]);

        $verify = NormalUser::where('phone-number',$fields['phone-number'])->first();

        if ($verify)
        {
            if ($verify['verified_otp'] == 1)
            {
                return response([
                    'success' => false,
                    'message' => 'Phone Number is already registered',
                    'data' => []
                ],401);
            }
        }

        $otp = rand(100000, 999999);
        $otpstring = strval($otp);
        $str2 = substr($fields['phone-number'], 4);

        $token = "_tGnrDluQo1JOqyLaILa-fTlozduLX5fW-JvtdDT4xW4OE2bDC_67DeBTYAe9fhl";

        // Prepare data for POST request
        $data = [
            "to"        =>      $fields['phone-number'],
            "message"   =>      "Your OTP is " . $otpstring ,
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

        $user = NormalUser::create([

            'username' => $fields['username'],
            'phone-number' => $fields['phone-number'],
            'password' => bcrypt($fields['password']),
            'profile-pic-source' => 'https://cdn.pixabay.com/photo/2017/06/13/12/53/profile-2398782_960_720.png',
            'user-level' => 'normal',
            'referral-code' => $this->generateRandomString(6),
            'credits' => '0000',
            'verified_otp' => '0',
            'otp' => strval($otp)
         ]);

         $fullresult = [
             'user' => $user,
            'smspoh' => $result
         ];

         return response([
             'success' => true,
             'message' => 'Create User Successfully',
             'data' => $fullresult
         ],201);
    }

    public function verifyOTP(Request $request)
    {   

        $fields = $request->validate([
            'phone-number' => 'required',
            'otp' => 'required'

        ]);
        
        $verifyPhone = NormalUser::where('phone-number', $fields['phone-number'])->first();

        $verifyPhoneOtp = NormalUser::where('phone-number', $fields['phone-number'])->value('otp');

        if ( $verifyPhone )
        {
            if( $verifyPhone->otp = $fields['otp'] )
            {
                $verifyPhone->update([
                    'verified_otp' => 1
                ]);

                $token = $verifyPhone->createToken('myapptoken')->plainTextToken;

            $Otpuser = [
             'user' => $verifyPhone,
             'token' => $token
            ];

                return response([
                    'success'=> true,
                    'message'=> 'Phone Number is verified',
                    'data' => $Otpuser
                ], 200);
            }
            else {
                return response([
                    'success'=> false,
                    'message'=> 'OTP is incorrect',
                    'data' => []
                ],400);
                }
            }
            else
            {
                return response([
                    'success'=> false,
                    'message'=> 'Phone Number does not exit',
                    'data' => []
                ],400);
            }
        
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'phone-number' => 'required',
            'password' => 'required'
        ]);

        $verifiedCheck = NormalUser::where('phone-number',$fields['phone-number'])->first();

        if (!$verifiedCheck || $verifiedCheck->verified_otp == 0)
        {
            return response([
                'success' => false,
                'message' => 'Your Phone Number is not registered',
                'data' => []
            ], 401);
        }
        elseif ( !Hash::check($fields['password'], $verifiedCheck->password))
        {
            return response([
                'success' => false,
                'message' => 'Your Phone Number and Password do not match',
                'data' => []
            ], 401);
        }
        else
        {   
            $token = $verifiedCheck->createToken('myapptoken')->plainTextToken;
            
            $user = [
                'user' => $verifiedCheck,
                'token' => $token
            ];

            return response([
                'success' => true,
                'message' => 'Login Successfully',
                'data' => $user
            ], 201);
        }
    }

    public function resetPassword(Request $request){

        $fields = $request->validate([
            'phone-number' => 'required'
        ]);

        $resetphone = NormalUser::where('phone-number',$fields['phone-number'])->first();

        if(!$resetphone || $resetphone['verified_otp'] == 0)
        {
            return response([
                'success'=> false,
                'message'=> 'Phone Number does not exit',
                'data' => []
            ],400);
        }

        $otp = rand(100000, 999999);
        $otpstring = strval($otp);

        $token = "_tGnrDluQo1JOqyLaILa-fTlozduLX5fW-JvtdDT4xW4OE2bDC_67DeBTYAe9fhl";

        // Prepare data for POST request
        $data = [
            "to"        =>      $fields['phone-number'],
            "message"   =>      "Your OTP is " . $otpstring ,
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
        
        $resetphone->update([
            'otp'  => $otpstring
        ]);

        return response([
            'success'=> false,
            'message'=> 'OTP is already sent for Password Reset',
            'data' => []
        ], 201);
    }

    public function verifyOTPreset(Request $request){

        $fields = $request->validate([
            'phone-number' => 'required|string',
            'otp' => 'required|string',
            'password' => 'required|string|confirmed|max:6'
        ]);

        $verifyphone = NormalUser::where('phone-number', $fields['phone-number'])->first();
        
        if (!$verifyphone)
        {
            return response([
                'success'=> false,
                'message'=> 'Phone Number does not exit',
                'data' => []
            ],400); 
        }

        if ($verifyphone->otp != $fields['otp'])
        {
            return response([
                'success'=> false,
                'message'=> 'OTP is not correct',
                'data' => []
            ],400);
        }

        $verifyphone->update([
            'password' => bcrypt($fields['password'])
        ]);

        return response([
                'success'=> true,
                'message'=> 'Password resets successfully',
                'data' => []
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
        return NormalUser::find($id);
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
        $fields = $request->validate([
            'username' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);
        $imageName = time().'.'.$request->image->extension();  
     
        $request->image->move(public_path('profileImages'), $imageName);

        $user = NormalUser::find($id);
        $user->update([
            'username' => $fields['username'],
            'profile-pic-source' => $imageName
        ]);
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return NormalUser::destroy($id);
    }

    
    public function searchReferral($name)
    {
        return NormalUser::where('referral-code', 'like', '%'.$name.'%')->get();
    }

    public function searchPhone($name)
    {
        return NormalUser::where('phone-number', 'like', '%'.$name.'%')->get();
    }
    
    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged Out'
        ];

    }
}
