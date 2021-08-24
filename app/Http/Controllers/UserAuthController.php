<?php

namespace App\Http\Controllers;

use App\Models\Bettors;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Bettors::all();
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
    public function store(Request $request)
    {
        $fields = $request->validate([

            'username' => 'required|string',
            'phone-number' => 'required|string|unique:bettors,phone-number',
            'password' => 'required|string'

        ]);

        
        $str2 = substr($fields['phone-number'], 4);

        $user = Bettors::create([

            'username' => $fields['username'],
            'phone-number' => $fields['phone-number'],
            'password' => $fields['password'],
            'profile-pic-source' => 'https://cdn.pixabay.com/photo/2017/06/13/12/53/profile-2398782_960_720.png',
            'user-level' => 'normal',
            'referral-code' => $this->generateRandomString(6),
            'credits' => '0000' 
         ]);

         return response($user,201);
    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Bettors::find($id);
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
        $user = Bettors::find($id);
        $user->update($request->all());
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
        return Bettors::destroy($id);
    }

    
    public function searchReferral($name)
    {
        return Bettors::where('referral-code', 'like', '%'.$name.'%')->get();
    }

    public function searchPhone($name)
    {
        return Bettors::where('phone-number', 'like', '%'.$name.'%')->get();
    }
}
