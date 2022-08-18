<?php

namespace App\Http\Controllers;

use App\Models\DthreeD;
use App\Models\DtwoD;
use App\Models\Internet;
use App\Models\CloseDay;
use Carbon\Carbon;

use Illuminate\Http\Request;

class ThreeDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function getVersion()
    {
        return response([
            'success' => true,
            'message' => 'Current Version',
            'data' => '1'
        ],200);
    }

    public function getCloseDay()
    {
        return response([
            'success' => true,
            'message' => 'Close Dates',
            'data' => CloseDay::all()
        ],200); 
    }
    
    public function indexInternet()
    {   
        $date = Carbon::now('Asia/Yangon');
        $date->setISODate(2022,$date->weekOfYear);
        $start = $date->startOfWeek(Carbon::MONDAY)->format('d.m.Y');
        $end = $date->endOfWeek(Carbon::FRIDAY)->format('d.m.Y');

        $monday = Internet::whereBetween('date',[$start,$end])->where('day','Monday')->get();
        $tuesday = Internet::whereBetween('date',[$start,$end])->where('day','Tuesday')->get();
        $wednesday = Internet::whereBetween('date',[$start,$end])->where('day','Wednesday')->get();
        $thursday = Internet::whereBetween('date',[$start,$end])->where('day','Thursday')->get();
        $friday = Internet::whereBetween('date',[$start,$end])->where('day','Friday')->get();

        $week = [
            'Monday' => [
                'noon' => Internet::where('date','14.02.2022')->where('day','Monday')->where('time','9:30 AM')->get(),
                'evening' => Internet::where('date','14.02.2022')->where('day','Monday')->where('time','2:00 PM')->get()
            ],
            'Tuesday' => [
                'noon' => Internet::where('date','15.02.2022')->where('day','Tuesday')->where('time','9:30 AM')->get(),
                'evening' => Internet::where('date','15.02.2022')->where('day','Tuesday')->where('time','2:00 PM')->get()
            ],
            'Wednesday' => [
                'noon' => Internet::where('date','16.02.2022')->where('day','Wednesday')->where('time','9:30 AM')->get(),
                'evening' => Internet::where('date','16.02.2022')->where('day','Wednesday')->where('time','2:00 PM')->get()
            ],
            'Thursday' => [
                'noon' => Internet::where('date','17.02.2022')->where('day','Thursday')->where('time','9:30 AM')->get(),
                'evening' => Internet::where('date','17.02.2022')->where('day','Thursday')->where('time','2:00 PM')->get()
            ],
            'Friday' => [
                'noon' => Internet::where('date','18.02.2022')->where('day','Friday')->where('time','9:30 AM')->get(),
                'evening' => Internet::where('date','18.02.2022')->where('day','Friday')->where('time','2:00 PM')->get()
            ]
            // 'Friday' => [
            //     'noon' => Internet::whereBetween('date',[$start,$end])->where('day','Friday')->where('time','9:30 AM')->get(),
            //     'evening' => Internet::whereBetween('date',[$start,$end])->where('day','Friday')->where('time','2:00 PM')->get()
            // ]
        ];

        return response([
            'success' => true,
            'message' => 'Current Week Results',
            'data' => $week
        ],200);

        // $date = Carbon::now('Asia/Yangon')->format('d-m-Y');
        // $time = Carbon::now('Asia/Yangon')->format('g:i A');
        // $day = Carbon::createFromFormat('d-m-Y',$date)->format('l');
        
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "https://luke.2dboss.com/api/luke/twod-result-live",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_TIMEOUT => 30000,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "GET",
        //     CURLOPT_HTTPHEADER => array(
        //         // Set Here Your Requesred Headers
        //         'Content-Type: application/json',
        //     ),
        // ));
        // $response = curl_exec($curl);
        // $err = curl_error($curl);
        // curl_close($curl);
        
        // if ($err) {
        //     return response("cURL Error #:" . $err);
        // } else {
        //     $r = json_decode($response,true);
        //     $set = $r['data']['set_430'];
        //     $value = $r['data']['val_430'];
        //     $modern = $r['data']['modern_200'];
        //     $internet = $r['data']['internet_200'];

        //     $set3d = substr($set,-2,2);
        //     $value3d = substr($value,-4,-3);
        //     $threed = $set3d.$value3d;

        //     DthreeD::insert([
        //         '3D' => $threed,
        //         'set' => $set,
        //         'value' => $value,
        //         'modern' => $modern,
        //         'internet' => $internet,
        //         'date' => $date,
        //         'day' => $day,
        //         'time' => $time
        //     ]); 
    }
    
    public function index()
    {   
        // $date = Carbon::now('Asia/Yangon');
        // $date->setISODate(2022,$date->weekOfYear);
        // $start = $date->startOfWeek(Carbon::MONDAY)->format('d.m.Y');
        // $end = $date->endOfWeek(Carbon::FRIDAY)->format('d.m.Y');

        // $monday = DthreeD::whereBetween('date',[$start,$end])->where('day','Monday')->get();
        // $tuesday = DthreeD::whereBetween('date',[$start,$end])->where('day','Tuesday')->get();
        // $wednesday = DthreeD::whereBetween('date',[$start,$end])->where('day','Wednesday')->get();
        // $thursday = DthreeD::whereBetween('date',[$start,$end])->where('day','Thursday')->get();
        // $friday = DthreeD::whereBetween('date',[$start,$end])->where('day','Friday')->get();

        // $week = [
        //     'Monday' => [
        //         'noon' => DthreeD::where('date','14.02.2022')->where('day','Monday')->where('time','12:01 PM')->get(),
        //         'evening' => DthreeD::where('date','14.02.2022')->where('day','Monday')->where('time','4:31 PM')->get()
        //     ],
        //     'Tuesday' => [
        //         'noon' => DthreeD::where('date','15.02.2022')->where('day','Tuesday')->where('time','12:01 PM')->get(),
        //         'evening' => DthreeD::where('date','15.02.2022')->where('day','Tuesday')->where('time','4:31 PM')->get()
        //     ],
        //     'Wednesday' => [
        //         'noon' => DthreeD::where('date','16.02.2022')->where('day','Wednesday')->where('time','12:01 PM')->get(),
        //         'evening' => DthreeD::where('date','16.02.2022')->where('day','Wednesday')->where('time','4:31 PM')->get()
        //     ],
        //     'Thursday' => [
        //         'noon' => DthreeD::where('date','17.02.2022')->where('day','Thursday')->where('time','12:01 PM')->get(),
        //         'evening' => DthreeD::where('date','17.02.2022')->where('day','Thursday')->where('time','4:31 PM')->get()
        //     ],
        //     'Friday' => [
        //         'noon' => DthreeD::where('date','18.02.2022')->where('day','Friday')->where('time','12:01 PM')->get(),
        //         'evening' => DthreeD::where('date','18.02.2022')->where('day','Friday')->where('time','4:31 PM')->get()
        //     ]
            
        // ];

        return response([
            'success' => true,
            'message' => 'Current Week Results',
            'data' => DtwoD::orderBy('id','desc')->get()
        ],200);

        // $date = Carbon::now('Asia/Yangon')->format('d-m-Y');
        // $time = Carbon::now('Asia/Yangon')->format('g:i A');
        // $day = Carbon::createFromFormat('d-m-Y',$date)->format('l');
        
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "https://luke.2dboss.com/api/luke/twod-result-live",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_TIMEOUT => 30000,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "GET",
        //     CURLOPT_HTTPHEADER => array(
        //         // Set Here Your Requesred Headers
        //         'Content-Type: application/json',
        //     ),
        // ));
        // $response = curl_exec($curl);
        // $err = curl_error($curl);
        // curl_close($curl);
        
        // if ($err) {
        //     return response("cURL Error #:" . $err);
        // } else {
        //     $r = json_decode($response,true);
        //     $set = $r['data']['set_430'];
        //     $value = $r['data']['val_430'];
        //     $modern = $r['data']['modern_200'];
        //     $internet = $r['data']['internet_200'];

        //     $set3d = substr($set,-2,2);
        //     $value3d = substr($value,-4,-3);
        //     $threed = $set3d.$value3d;

        //     DthreeD::insert([
        //         '3D' => $threed,
        //         'set' => $set,
        //         'value' => $value,
        //         'modern' => $modern,
        //         'internet' => $internet,
        //         'date' => $date,
        //         'day' => $day,
        //         'time' => $time
        //     ]); 
    }

    public function weekResult()
    {   
        $date = Carbon::now('Asia/Yangon');
        $date->setISODate(2022,$date->weekOfYear);
        $start = $date->startOfWeek(Carbon::MONDAY)->format('d.m.Y');
        $end = $date->endOfWeek(Carbon::FRIDAY)->format('d.m.Y');

        $monday = DthreeD::whereBetween('date',[$start,$end])->where('day','Monday')->get();
        $tuesday = DthreeD::whereBetween('date',[$start,$end])->where('day','Tuesday')->get();
        $wednesday = DthreeD::whereBetween('date',[$start,$end])->where('day','Wednesday')->get();
        $thursday = DthreeD::whereBetween('date',[$start,$end])->where('day','Thursday')->get();
        $friday = DthreeD::whereBetween('date',[$start,$end])->where('day','Friday')->get();

        $week = [
            'Monday' => [
                'noon' => DthreeD::where('date','25.07.2022')->where('day','Monday')->where('time','12:01 PM')->get(),
                'evening' => DthreeD::where('date','25.07.2022')->where('day','Monday')->where('time','4:30 PM')->get()
            ],
            'Tuesday' => [
                'noon' => DthreeD::where('date','26.07.2022')->where('day','Tuesday')->where('time','12:01 PM')->get(),
                'evening' => DthreeD::where('date','26.07.2022')->where('day','Tuesday')->where('time','4:30 PM')->get()
            ],
            'Wednesday' => [
                'noon' => DthreeD::where('date','27.07.2022')->where('day','Wednesday')->where('time','12:01 PM')->get(),
                'evening' => DthreeD::where('date','27.07.2022')->where('day','Wednesday')->where('time','4:30 PM')->get()
            ],
            'Thursday' => [
                'noon' => DthreeD::where('date','28.07.2022')->where('day','Thursday')->where('time','12:01 PM')->get(),
                'evening' => DthreeD::where('date','28.07.2022')->where('day','Thursday')->where('time','4:30 PM')->get()
            ],
            'Friday' => [
                'noon' => DthreeD::where('date','29.07.2022')->where('day','Friday')->where('time','12:01 PM')->get(),
                'evening' => DthreeD::where('date','29.07.2022')->where('day','Friday')->where('time','4:30 PM')->get()
            ]
            
        ];

        return response([
            'success' => true,
            'message' => 'Current Week Results',
            'data' => $week
        ],200);

        // $date = Carbon::now('Asia/Yangon')->format('d-m-Y');
        // $time = Carbon::now('Asia/Yangon')->format('g:i A');
        // $day = Carbon::createFromFormat('d-m-Y',$date)->format('l');
        
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "https://luke.2dboss.com/api/luke/twod-result-live",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_TIMEOUT => 30000,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "GET",
        //     CURLOPT_HTTPHEADER => array(
        //         // Set Here Your Requesred Headers
        //         'Content-Type: application/json',
        //     ),
        // ));
        // $response = curl_exec($curl);
        // $err = curl_error($curl);
        // curl_close($curl);
        
        // if ($err) {
        //     return response("cURL Error #:" . $err);
        // } else {
        //     $r = json_decode($response,true);
        //     $set = $r['data']['set_430'];
        //     $value = $r['data']['val_430'];
        //     $modern = $r['data']['modern_200'];
        //     $internet = $r['data']['internet_200'];

        //     $set3d = substr($set,-2,2);
        //     $value3d = substr($value,-4,-3);
        //     $threed = $set3d.$value3d;

        //     DthreeD::insert([
        //         '3D' => $threed,
        //         'set' => $set,
        //         'value' => $value,
        //         'modern' => $modern,
        //         'internet' => $internet,
        //         'date' => $date,
        //         'day' => $day,
        //         'time' => $time
        //     ]); 
    }
    public function weeknumber($year,$weekno)
    {   
        $date = Carbon::now('Asia/Yangon');
        $now = Carbon::now('Asia/Yangon');
        $date->setISODate($year,$weekno);
        $start = $date->startOfWeek()->format('d.m.Y');
        $end = $date->endOfWeek()->format('d.m.Y');
        
        
        $monday = DthreeD::whereBetween('date',[$start,$end])->where('day','Monday')->get();
        $tuesday = DthreeD::whereBetween('date',[$start,$end])->where('day','Tuesday')->get();
        $wednesday = DthreeD::whereBetween('date',[$start,$end])->where('day','Wednesday')->get();
        $thursday = DthreeD::whereBetween('date',[$start,$end])->where('day','Thursday')->get();
        $friday = DthreeD::whereBetween('date',[$start,$end])->where('day','Friday')->get();

        $week = [
            'Monday' => [
                'noon' => DthreeD::whereBetween('date',[$start,$end])->where('day','Monday')->where('time','12:01 PM')->get(),
                'evening' => DthreeD::whereBetween('date',[$start,$end])->where('day','Monday')->where('time','4:31 PM')->get()
            ],
            'Tuesday' => [
                'noon' => DthreeD::whereBetween('date',[$start,$end])->where('day','Tuesday')->where('time','12:01 PM')->get(),
                'evening' => DthreeD::whereBetween('date',[$start,$end])->where('day','Tuesday')->where('time','4:31 PM')->get()
            ],
            'Wednesday' => [
                'noon' => DthreeD::whereBetween('date',[$start,$end])->where('day','Wednesday')->where('time','12:01 PM')->get(),
                'evening' => DthreeD::whereBetween('date',[$start,$end])->where('day','Wednesday')->where('time','4:31 PM')->get()
            ],
            'Thursday' => [
                'noon' => DthreeD::whereBetween('date',[$start,$end])->where('day','Thursday')->where('time','12:01 PM')->get(),
                'evening' => DthreeD::whereBetween('date',[$start,$end])->where('day','Thursday')->where('time','4:31 PM')->get()
            ],
            'Friday' => [
                'noon' => DthreeD::whereBetween('date',[$start,$end])->where('day','Friday')->where('time','12:01 PM')->get(),
                'evening' => DthreeD::whereBetween('date',[$start,$end])->where('day','Friday')->where('time','4:31 PM')->get()
            ]
        ];

        if(!DthreeD::whereBetween('date',[$start,$end])->first() || $year.$weekno > $year.$now->weekOfYear )
        {  
            return response([
                'success' => false,
                'message' => 'Results Not Available',
                'data' => (object)[]
            ],200);
        }

        return response([
            'success' => true,
            'message' => 'Current Week Results',
            'data' => $week
        ],200);
    }

public function checkTime(){

        $currentDay = Carbon::now('Asia/Yangon')->format('d');
        $currentMonth = Carbon::now('Asia/Yangon')->format('m');
        $currentYear = Carbon::now('Asia/Yangon')->format('Y');
        

        $NoonLimit = Carbon::create($currentYear,$currentMonth,$currentDay,10,30,00, 'Asia/Yangon');
        $EveningLimit = Carbon::create($currentYear,$currentMonth,$currentDay,15,45,00, 'Asia/Yangon');
        $Closed = Carbon::createFromDate(2022,02,16, 'Asia/Yangon')->format('d.m.Y');
        $UserTime = Carbon::now('Asia/Yangon');
        
        if ( Carbon::now('Asia/Yangon')->format('d.m.Y') == $Closed )
        {
            return response([
                'success' => false,
                'message' => 'Betting is closed',
                'data' => (object)[]
            ],200);
        }

        if( $UserTime->gt($EveningLimit) )
        {
            if ( Carbon::tomorrow('Asia/Yangon')->format('d.m.Y') == $Closed || Carbon::tomorrow('Asia/Yangon')->isWeekend() )
            {
                return response([
                    'success' => false,
                    'message' => 'Tomorrow is closed',
                    'data' => (object)[]
                ],200);
            }
            
        }


        $time = Carbon::now('Asia/Yangon')->format('d-m-Y H:i:s');
        // $out = [
        //     'twod' => DtwoD::all(),
        //     'time' => $time
        // ];

        if ( !Carbon::now('Asia/Yangon')->isWeekend() )
        {
            if ( $UserTime->lt($NoonLimit) )
        {   
            $noonTime = [
                'currentTime' => Carbon::now('Asia/Yangon'),
                'limited' => '11:30 PM',
                'forTime' => '12:01 PM'
            ];

            $eveningTime = [
                'currentTime' => Carbon::now('Asia/Yangon'),
                'limited' => '03:30 PM',
                'forTime' => '4:30 PM'
            ];

            $avail = [
                'bet-time' => '(10:30 AM) (3:45 PM)',
                'forDate' => Carbon::now('Asia/Yangon')->format('d.m.Y'),
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
                'currentTime' => Carbon::now('Asia/Yangon'),
                'limited' => '03:30 PM',
                'forTime' => '4:30 PM'
            ];

            $avail = [
                'bet-time' => '(10:30 AM) (3:45 PM)',
                'forDate' => Carbon::now('Asia/Yangon')->format('d.m.Y'),
                'noonTime' => (object)[],
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
                'currentTime' => Carbon::now('Asia/Yangon'),
                'limited' => '11:30 AM',
                'forTime' => '12:01 PM'
            ];

            $eveningTime = [
                'currentTime' => Carbon::now('Asia/Yangon'),
                'limited' => '03:30 PM',
                'forTime' => '4:30 PM'
            ];

            $avail = [
                'bet-time' => '(10:30 AM) (3:45 PM)',
                'forDate' => Carbon::tomorrow('Asia/Yangon')->format('d.m.Y'),
                'noonTime' => $noonTime,
                'eveningTime' => $eveningTime
            ];
            return response([
                'success' => true,
                'message' => 'Available Betting Time',
                'data' => $avail
            ],200);
        }
        elseif ( Carbon::tomorrow('Asia/Yangon')->isWeekend()  || $UserTime->gt($EveningLimit) )
        {
            return response([
                'success' => false,
                'message' => 'Betting is closed in Weekend',
                'data' => (object)[]
            ],200);
        }
      }
      else
      {
        return response([
            'success' => false,
            'message' => 'Betting is closed in Weekend',
            'data' => (object)[]
        ],200);
      }
        
    }

public function checkInternetTime(){

        $currentDay = Carbon::now('Asia/Yangon')->format('d');
        $currentMonth = Carbon::now('Asia/Yangon')->format('m');
        $currentYear = Carbon::now('Asia/Yangon')->format('Y');
        

        $NoonLimit = Carbon::create($currentYear,$currentMonth,$currentDay,9,00,00, 'Asia/Yangon');
        $EveningLimit = Carbon::create($currentYear,$currentMonth,$currentDay,13,30,00, 'Asia/Yangon');
        $Closed = Carbon::createFromDate(2022,02,16, 'Asia/Yangon')->format('d.m.Y');
        $UserTime = Carbon::now('Asia/Yangon');
        
        if ( Carbon::now('Asia/Yangon')->format('d.m.Y') == $Closed )
        {
            return response([
                'success' => false,
                'message' => 'Betting is closed',
                'data' => (object)[]
            ],200);
        }

        if( $UserTime->gt($EveningLimit) )
        {
            if ( Carbon::tomorrow('Asia/Yangon')->format('d.m.Y') == $Closed || Carbon::tomorrow('Asia/Yangon')->isWeekend() )
            {
                return response([
                    'success' => false,
                    'message' => 'Tomorrow is closed',
                    'data' => (object)[]
                ],200);
            }
        }

        $time = Carbon::now('Asia/Yangon')->format('d-m-Y H:i:s');
        // $out = [
        //     'twod' => DtwoD::all(),
        //     'time' => $time
        // ];

        if ( !Carbon::now('Asia/Yangon')->isWeekend() )
        {
            if ( $UserTime->lt($NoonLimit) )
        {   
            $noonTime = [
                'currentTime' => Carbon::now('Asia/Yangon'),
                'limited' => '09:00 AM',
                'forTime' => '09:30 AM'
            ];

            $eveningTime = [
                'currentTime' => Carbon::now('Asia/Yangon'),
                'limited' => '01:30 PM',
                'forTime' => '02:00 PM'
            ];

            $avail = [
                'bet-time' => '(9:00 AM) (1:30 PM)',
                'forDate' => Carbon::now('Asia/Yangon')->format('d.m.Y'),
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
                'currentTime' => Carbon::now('Asia/Yangon'),
                'limited' => '01:30 PM',
                'forTime' => '02:00 PM'
            ];

            $avail = [
                'bet-time' => '(9:00 AM) (1:30 PM)',
                'forDate' => Carbon::now('Asia/Yangon')->format('d.m.Y'),
                'noonTime' => (object)[],
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
                'currentTime' => Carbon::now('Asia/Yangon'),
                 'limited' => '09:00 AM',
                 'forTime' => '09:30 AM'
            ];

            $eveningTime = [
                'currentTime' => Carbon::now('Asia/Yangon'),
                'limited' => '01:30 PM',
                'forTime' => '02:00 PM'
            ];

            $avail = [
                'bet-time' => '(9:00 AM) (1:30 PM)',
                'forDate' => Carbon::tomorrow('Asia/Yangon')->format('d.m.Y'),
                'noonTime' => $noonTime,
                'eveningTime' => $eveningTime
            ];
            return response([
                'success' => true,
                'message' => 'Available Betting Time',
                'data' => $avail
            ],200);
        }
        elseif ( Carbon::tomorrow('Asia/Yangon')->isWeekend()  || $UserTime->gt($EveningLimit) )
        {
            return response([
                'success' => false,
                'message' => 'Betting is closed in Weekend',
                'data' => (object)[]
            ],200);
        }
      }
      else
      {
        return response([
            'success' => false,
            'message' => 'Betting is closed in Weekend',
            'data' => (object)[]
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
            '3D' => 'required',
            'modern' => 'required',
            'internet' => 'required',
            'set' => 'required',
            'value' => 'required',
            'time' => 'required',
            'date' =>'required',
            'day' =>'required'

        ]);
        return response([
            'success' => true,
            'message' => 'Data Created',
            'data' => DthreeD::create($request->all())
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
            'data' => DthreeD::find($id)
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
        $threed = DthreeD::find($id);
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
            'data' => DthreeD::destroy($id)
        ],203); 
    }

    public function search($name)
    {   
        $dated = DthreeD::where('date', 'like', '%'.$name.'%')->get();
        if (!DthreeD::where('date', 'like', '%'.$name.'%')->first()) 
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
}
