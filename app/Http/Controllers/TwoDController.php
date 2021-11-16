<?php

namespace App\Http\Controllers;

use App\Models\DtwoD;
use Goutte\Client;
use App\Models\DthreeD;
// use Symfony\Component\HttpClient\HttpClient;
// use Symfony\Component\DomCrawler\Crawler;
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
        $noti_token = "MjU1MTBhMjMtY2RmMi00NzU4LTliZGUtZWQwYzViNWUxMDNk";

        $contents = [
            'en' => '4:30 PM Win Number is'
        ];

        $headings = [
            'en' => '4:30 PM Win Number'
        ];

        $data2 = [
            'type' => 'all'
        ];

        $noti_data = [
            'app_id' => 'e6748a7e-69c4-4f58-bc2f-36eaa11ecbb2',
            'included_segments' => 'Subscribed Users',
            'data' => $data2,
            'headings' => $headings,
            'contents' => $contents
        ];

        $ch2 = curl_init("https://onesignal.com/api/v1/notifications");
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($noti_data));
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $noti_token,
                'Content-Type: application/json'
            ]);
        
        $result2 = curl_exec($ch2);

        return response($result2);
        // $date = Carbon::now('Asia/Yangon');
        // $date->setISODate(2021,$date->weekOfYear);
        // $start = $date->startOfWeek()->format('d.m.Y');
        // $end = $date->endOfWeek()->format('d.m.Y');

        

        
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
        //     return $r['data']['set_1200'];
        // }
        // return response([
        //     'success' => true,
        //     'message' => 'Data Found',
        //     'data' => DtwoD::all()
        // ],200);
        
        // $client = new Client();
        // $crawler = $client->request('GET','https://marketdata.set.or.th/mkt/marketsummary.do?language=en&country=US');

        // $link1 = $crawler->filter('.table-info tr td')->eq(1)->text();
        // $link2 = $crawler->filter('.table-info tr td')->eq(7)->text();
        // $set = substr($link1,-2,2);
        // $value = substr($link2,-4,-3);
        // $twod = $set.$value;
        
        // $data = [
        //     'set' => $link1,
        //     'value' => $link2,
        //     'twod' => $twod
        // ];
        // return response([
        //     'success' => true,
        //     'message' => 'Data Found',
        //     'data' => $data
        // ],200);
    }

public function checkTime(){

        $currentDay = Carbon::now('Asia/Yangon')->format('d');
        $currentMonth = Carbon::now('Asia/Yangon')->format('m');
        $currentYear = Carbon::now('Asia/Yangon')->format('Y');
        

        $NoonLimit = Carbon::create($currentYear,$currentMonth,$currentDay,10,30,00, 'Asia/Yangon');
        $EveningLimit = Carbon::create($currentYear,$currentMonth,$currentDay,15,45,00, 'Asia/Yangon');
        $Closed = Carbon::createFromDate(2021,10,22, 'Asia/Yangon')->format('d.m.Y');
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
            if ( Carbon::tomorrow('Asia/Yangon')->format('d.m.Y') == $Closed || Carbon::tomorrow('Asia/Yangon')->isWeekend())
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
                'forTime' => $NoonLimit
            ];

            $eveningTime = [
                'currentTime' => Carbon::now('Asia/Yangon'),
                'limited' => '03:30 PM',
                'forTime' => $UserTime
            ];

            $avail = [
                'bet-time' => 'Both Lottery Time Available',
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
                'forTime' => '4:31 PM'
            ];

            $avail = [
                'bet-time' => 'Betting Closed for 12:01 PM. 4:31 PM is still open',
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
                'limited' => '11:30 PM',
                'forTime' => '12:01 PM'
            ];

            $eveningTime = [
                'currentTime' => Carbon::now('Asia/Yangon'),
                'limited' => '03:30 PM',
                'forTime' => '4:31 PM'
            ];

            $avail = [
                'bet-time' => 'Today Betting is closed. Bet for Tomorrow',
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
        elseif ( $UserTime->gt($EveningLimit) && Carbon::tomorrow('Asia/Yangon')->isWeekend())
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
