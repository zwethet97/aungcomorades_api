<?php

namespace App\Http\Controllers;
use App\Models\Noti;
use Illuminate\Http\Request;

class NotiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        
    }

    public function showbyUserId($id)
    {
        $allnoti = Noti::where('userId','all')->orderBy('id','DESC')->get();
        $notibyuserId = Noti::where('userId',$id)->orderBy('id','DESC')->get();

        $allnoti = [
            'annoucements' => [],
            'user noti' => $notibyuserId
        ];
        if (!Noti::where('userId', $id)->first() )
        {
        return response([
            'success' => false,
            'message' => 'No Notifications',
            'data' => []
        ],200);
        }
        return response([
            'success' => true,
            'message' => 'Notifications',
            'data' => $allnoti
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
