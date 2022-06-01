<?php

namespace App\Http\Controllers;
use App\Models\Tips;
use App\Models\SoccerTips;
use App\Models\todayTips;
use App\Models\SoccerTodayTips;
use App\Models\TipBanner;
use App\Models\TipRecord;
use Carbon\Carbon;

use Illuminate\Http\Request;

class TipsController extends Controller
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
            'message' => 'Tips Profile Found',
            'data' => Tips::all()
        ],200);

    }
    
    public function showBanner()
    {
        return response([
            'success'=> true,
            'message'=> 'Tip Banner',
            'data' => TipBanner::all()
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
    public function showTwodTips($id)
    {
        
    }

    public function searchTwoDTodayTips($id)
    {   
        $today = Carbon::now('Asia/Yangon')->format('d.m.Y');
        $dated = todayTips::where('tip_id',$id)
                ->get();
        if (!todayTips::where('tip_id',$id)->first()) 
        {
            return response([
                'success' => false,
                'message' => 'Date Not Found',
                'data' => []
            ],200);
        }

        return response([
            'success' => true,
            'message' => 'Date Found',
            'data' => $dated
        ],200);
    }

    public function searchSoccerTodayTips($id)
    {   
        
        $today = Carbon::now()->format('d.m-Y');
        $dated = SoccerTodayTips::where('date', 'like', '%'.$today.'%')
                ->where('soccer_tips_id',$id)
                ->get();
        if (!SoccerTodayTips::where('date', 'like', '%'.$today.'%')->first()) 
        {
            return response([
                'success' => false,
                'message' => 'Date Not Found',
                'data' => []
            ],200);
        }

        return response([
            'success' => true,
            'message' => 'Date Found',
            'data' => $dated
        ],200);
    }

    public function searchTodayTips($name)
    {   
        $dated = DtodayTips::where('date', 'like', '%'.$name.'%')->get();
        if (!DtodayTips::where('date', 'like', '%'.$name.'%')->first()) 
        {
            return response([
                'success' => false,
                'message' => 'Date Not Found',
                'data' => []
            ],200);
        }

        return response([
            'success' => true,
            'message' => 'Date Found',
            'data' => $dated
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchTipsHistory($id)
    {
        $history = TipRecord::where('tip_id',$id)->get();
        
        if (!TipRecord::where('tip_id',$id)->first()) 
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
            'data' => $history
        ],200);    
    }

    // public function searchSoccerTipsHistory($id)
    // {
    //     $history = SoccerTodayTips::where('soccer_tips_id',$id)->get();
    //     return response([
    //         'success' => true,
    //         'message' => 'Data Found',
    //         'data' => $history
    //     ],200);    
    // }


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
