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
        $twodTips = Tips::all();
        $soccerTips = SoccerTips::all();

        $tips = [
            '2D Tips' => $twodTips,
            'Soccer Tips' => $soccerTips
        ];
        return response([
            'success' => true,
            'message' => 'Date Found',
            'data' => $tips
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
        $today = Carbon::now()->format('d.m.Y');
        $dated = todayTips::where('date', 'like', '%'.$today.'%')
                ->where('tip_id',$id)
                ->get();
        if (!todayTips::where('date', 'like', '%'.$today.'%')->first()) 
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
        
        $today = Carbon::now()->format('d-m-Y');
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
