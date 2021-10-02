<?php

namespace App\Http\Controllers;

use App\Models\DtwoD;

use Illuminate\Http\Request;
use Carbon\Carbon;

class TwoDController extends Controller
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
            'data' => DtwoD::all()
        ],200);
    }

    public function checkTime(){

        $currentDay = Carbon::now('Asia/Yangon')->format('d');
        $currentMonth = Carbon::now('Asia/Yangon')->format('m');
        $currentYear = Carbon::now('Asia/Yangon')->format('Y');
        

        $NoonLimit = Carbon::create($currentYear,$currentMonth,$currentDay,11,01,00, 'Asia/Yangon');
        $EveningLimit = Carbon::create($currentYear,$currentMonth,$currentDay,16,31,00, 'Asia/Yangon');
        $UserTime = Carbon::now('Asia/Yangon');


        $time = Carbon::now('Asia/Yangon')->format('d-m-Y H:i:s');
        $out = [
            'twod' => DtwoD::all(),
            'time' => $time
        ];

        if ( !Carbon::now('Asia/Yangon')->isWeekend() )
        {
            if ( $UserTime->lt($NoonLimit) )
        {   
            $noonTime = [
                'forDate' => Carbon::now('Asia/Yangon')->format('d-m-Y'),
                'forTime' => $NoonLimit
            ];

            $eveningTime = [
                'forDate' => Carbon::now('Asia/Yangon')->format('d-m-Y'),
                'forTime' => $UserTime
            ];

            $avail = [
                'bet-time' => 'Both Lottery Time Available',
                'noonTime' => $noonTime,
                'eveningTime' => $eveningTime
            ];
            return response([
                'success' => true,
                'message' => 'Available Betting Time',
                'data' => $avail
            ],200);
        }
        elseif ($UserTime->gt($NoonLimit) && $UserTime->lt($EveningLimit))
        {
            $eveningTime = [
                'forDate' => Carbon::now('Asia/Yangon')->format('d-m-Y'),
                'forTime' => '4:31 PM'
            ];

            $avail = [
                'bet-time' => 'Betting Closed for 12:01 PM. 4:31 PM is still open',
                'eveningTime' => $eveningTime
            ];
            return response([
                'success' => true,
                'message' => 'Available Betting Time',
                'data' => $avail
            ],200);
        }
        elseif ($UserTime->gt($EveningLimit))
        {
            $noonTime = [
                'forDate' => Carbon::tomorrow('Asia/Yangon')->format('d-m-Y'),
                'forTime' => '12:01 PM'
            ];

            $eveningTime = [
                'forDate' => Carbon::tomorrow('Asia/Yangon')->format('d-m-Y'),
                'forTime' => '4:31 PM'
            ];

            $avail = [
                'bet-time' => 'Today Betting is closed. Bet for Tomorrow',
                'noonTime' => $noonTime,
                'eveningTime' => $eveningTime
            ];
            return response([
                'success' => true,
                'message' => 'Available Betting Time',
                'data' => $avail
            ],200);
        }
        elseif ( $UserTime->gt($EveningLimit) && Carbon::tomorrow('Asia/Yangon')->isWeekend())
        {
            return response([
                'success' => false,
                'message' => 'Betting is closed in Weekend',
                'data' => []
            ],200);
        }


      }
      else
      {
        return response([
            'success' => false,
            'message' => 'Betting is closed in Weekend',
            'data' => []
        ],200);
      }
        
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
            '2D' => 'required',
            'modern' => 'required',
            'internet' => 'required',
            'time' => 'required',
            'date' =>'required',
            'day' =>'required'

        ]);
        return response([
            'success' => true,
            'message' => 'Data Created',
            'data' => DtwoD::create($request->all())
        ],201); ; 
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
            'data' => DtwoD::find($id)
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
        $threed = DtwoD::find($id);
        $threed->update($request->all());
        return response([
            'success' => true,
            'message' => 'Data Updated',
            'data' => $threed
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
            'message' => 'Data Deleted Successfully',
            'data' => DtwoD::destroy($id)
        ],203); 
    }

    public function search($name)
    {   
        $dated = DtwoD::where('date', 'like', '%'.$name.'%')->get();
        if (!DtwoD::where('date', 'like', '%'.$name.'%')->first()) 
        {
            return response([
                'success' => false,
                'message' => 'Date Not Found',
                'data' => []
            ],401);
        }

        return response([
            'success' => true,
            'message' => 'Date Found',
            'data' => $dated
        ],200);
        
    }
}
