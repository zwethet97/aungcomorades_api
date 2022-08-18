<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\DthreeD;
use App\Models\DtwoD;
use App\Models\Internet;
use App\Models\Noti;
use App\Models\BetSlip;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\TwelveThreeD::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->call(function(){
                
                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                $time = Carbon::now('Asia/Yangon')->format('g:i A');
                $day = Carbon::createFromFormat('d.m.Y',$date)->format('l');
                
                Internet::insert([
                        'internet' => '--',
                        'date' => $date,
                        'day' => $day,
                        'time' => '9:30 AM'
                    ]);
            })->weekdays()->timezone('Asia/Yangon')->at('9:30');
            
        
        // $schedule->call(function(){
        //         $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        //         $time = Carbon::now('Asia/Yangon')->format('g:i A');
        //         $day = Carbon::createFromFormat('d.m.Y',$date)->format('l');
                
        //         if ( $time >= '9:30 AM')
        //         {
        //         $winNo = Internet::where('date',$date)->where('time','9:30 AM')->value('internet');
        //         $loseSlips = BetSlip::where('forDate',$date)->where('forTime','09:30 AM')->where('type','INTERNET')->where('status','ongoing')->get();
        //         if ( $winNo )
        //         {
        //         foreach ( $loseSlips as $loseSlip)
        //         {
        //         $loseSlip->update([
        //             'win_number' => $winNo,
        //             'status' => 'lose'
        //             ]);
                
        //         }
        //         }
        //         }
        // })->weekdays()->timezone('Asia/Yangon')->at('09:45');


        $schedule->call(function(){
                    // $client = new Client();
                    // $crawler = $client->request('GET','https://marketdata.set.or.th/mkt/marketsummary.do?language=en&country=US');
            
                    // $set = $crawler->filter('.table-info tr td')->eq(1)->text();
                    // $value = $crawler->filter('.table-info tr td')->eq(7)->text();
                    $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                $time = Carbon::now('Asia/Yangon')->format('g:i A');
                $day = Carbon::createFromFormat('d.m.Y',$date)->format('l');
                
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://luke.2dboss.com/api/luke/twod-result-live",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_TIMEOUT => 30000,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        // Set Here Your Requesred Headers
                        'Content-Type: application/json',
                    ),
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                
                if ($err) {
                    return response("cURL Error #:" . $err);
                } else {
                    $r = json_decode($response,true);
                    $set = $r['data']['set_1200'];
                    $value = $r['data']['val_1200'];
                    $modern = $r['data']['modern_930'];
                    $internet = $r['data']['internet_930'];

                    $set3d = substr($set,-2,2);
                    $value3d = substr($value,-4,-3);
                    $threed = $set3d.$value3d;

                    if ( $r['data']['is_close_day'] == 0) 
                    {
                    DthreeD::insert([
                        '3D' => $threed,
                        'set' => $set,
                        'value' => $value,
                        'modern' => $modern,
                        'internet' => $internet,
                        'date' => $date,
                        'tw_1206' => '--',
                        'day' => $day,
                        'time' => '12:01 PM',
                        'plustwod' => '--'
                    ]);
                    
                    $noti_token = "key=AAAADpmIKkI:APA91bEOn4spIMf-61k3Y7okH7998nwvVzeXJvGrJfMriiWGo6-VUMO6zJmMPLutJiwHJOyNljbrMHPZpCQLNsrTo4LvwHujwgVG-8YzBPdv5kRUdE3iCSi5L_bC2wqhtyA1QNdEh3hB";

                $data = [
                    'noti_data' => 'lottery'
                ];

                $notification = [
                    'title' => '2D (12:01 Number) is out!',
                    'body' => '12:01 Win Number is '.$threed[1].$threed[2]
                ];


                $noti_data = [
                    'priority' => 'HIGH',
                    'data' => $data,
                    'notification' => $notification,
                    'to' => '/topics/aungnamate'
                ];

                $ch2 = curl_init("https://fcm.googleapis.com/fcm/send");
                curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($noti_data));
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch2, CURLOPT_HTTPHEADER, [
                        'Authorization:'.$noti_token,
                        'Content-Type: application/json'
                    ]);
                
                $result2 = curl_exec($ch2);
                        }
                        if ($r['data']['is_close_day'] == 1)
                        {
                        DthreeD::insert([
                            '3D' => '---',
                            'set' => '---',
                            'value' => '---',
                            'modern' => '--',
                            'internet' => '--',
                            'tw_1206' => '--',
                            'date' => $date,
                            'day' => $day,
                            'time' => '12:01 PM',
                            'plustwod' => '--'
                        ]);
                            }
                }
            })->weekdays()->timezone('Asia/Yangon')->at('12:01');
            
            // $schedule->call(function(){
            //         $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
            //         $time = Carbon::now('Asia/Yangon')->format('g:i A');
            //         $day = Carbon::createFromFormat('d.m.Y',$date)->format('l');
                    
                    
            //         $winNo = DthreeD::where('date',$date)->where('time','12:01 PM')->value('3D');
            //         $winNoPlus = DthreeD::where('date',$date)->where('time','12:01 PM')->value('plustwod');
                    
    
            //         $loseSlips = BetSlip::where('forDate',$date)->where('forTime','12:01 PM')->whereIn('type',['D3D','D2D'])->where('status','ongoing')->get();
            //         $loseSlipsPlus = BetSlip::where('forDate',$date)->where('forTime','12:01 PM')->whereIn('type',['2DPLUS'])->where('status','ongoing')->get();
                    
            //          foreach ( $loseSlips as $loseSlip)
            //          {
            //              $loseSlip->update([
            //             'win_number' => $winNo,
            //             'status' => 'lose'
            //             ]);
                        
            //          }
            //          foreach ( $loseSlipsPlus as $loseSlipPlus)
            //          {
            //              $loseSlipPlus->update([
            //             'win_number' => $winNoPlus,
            //             'status' => 'lose'
            //             ]);
            //          }
            // })->weekdays()->timezone('Asia/Yangon')->at('12:25');
            
             $schedule->call(function(){
                
                 $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                $time = Carbon::now('Asia/Yangon')->format('g:i A');
                $day = Carbon::createFromFormat('d.m.Y',$date)->format('l');
                
                Internet::insert([
                        'internet' => '--',
                        'date' => $date,
                        'day' => $day,
                        'time' => '2:00 PM'
                    ]);
            })->weekdays()->timezone('Asia/Yangon')->at('14:00');
                
        //     $schedule->call(function(){
        //         $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
        //         $time = Carbon::now('Asia/Yangon')->format('g:i A');
        //         $day = Carbon::createFromFormat('d.m.Y',$date)->format('l');
                
                
        //         $winNo = Internet::where('date',$date)->where('time','2:00 PM')->value('internet');
        //         $loseSlips = BetSlip::where('forDate',$date)->where('forTime','2:00 PM')->where('type','INTERNET')->where('status','ongoing')->get();
           
        //       foreach ( $loseSlips as $loseSlip)
        //         {
        //         $loseSlip->update([
        //             'win_number' => $winNo,
        //             'status' => 'lose'
        //             ]);
                
        //         }
        // })->weekdays()->timezone('Asia/Yangon')->at('14:15');
                
           



            $schedule->call(function(){
                // $client = new Client();
                // $crawler = $client->request('GET','https://marketdata.set.or.th/mkt/marketsummary.do?language=en&country=US');
        
                // $set = $crawler->filter('.table-info tr td')->eq(1)->text();
                // $value = $crawler->filter('.table-info tr td')->eq(7)->text();
                $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
                $time = Carbon::now('Asia/Yangon')->format('g:i A');
                $day = Carbon::createFromFormat('d.m.Y',$date)->format('l');
                
                $curl = curl_init();
        
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://luke.2dboss.com/api/luke/twod-result-live",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_TIMEOUT => 30000,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        // Set Here Your Requesred Headers
                        'Content-Type: application/json',
                    ),
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                
                if ($err) {
                    return response("cURL Error #:" . $err);
                } else {
                    $r = json_decode($response,true);
                    $set = $r['data']['set_1200'];
                    $value = $r['data']['val_1200'];
                    $modern = $r['data']['modern_930'];
                    $internet = $r['data']['internet_930'];

                    $set3d = substr($set,-2,2);
                    $value3d = substr($value,-4,-3);
                    $threed = $set3d.$value3d;
                    $sete = $r['data']['set_430'];
                    $valuee = $r['data']['val_430'];
                    $moderne = $r['data']['modern_200'];
                    $internete = $r['data']['internet_200'];
        
                    $set3de = substr($sete,-2,2);
                    $value3de = substr($valuee,-4,-3);
                    $threede = $set3de.$value3de;
                    
            if ( $r['data']['is_close_day'] == 0) 
                    {
                    DtwoD::insert([
                        '2d_1201' => $threed[1].$threed[2],
                        'set_1201' => $set,
                        'value_1201' => $value,
                        'modern_930' => $modern,
                        'internet_930' => $internet,
                        '2d_430' => $threede[1].$threede[2],
                        'set_430' => $sete,
                        'value_430' => $valuee,
                        'modern_200' => $moderne,
                        'internet_200' => $internete,
                        'date' => $date,
                        'tw_1206' => '--',
                        'day' => $day
                    ]);
                    
                    DthreeD::insert([
                        '3D' => $threede,
                        'set' => $sete,
                        'value' => $valuee,
                        'modern' => $moderne,
                        'internet' => $internete,
                        'date' => $date,
                        'tw_1206' => '--',
                        'day' => $day,
                        'time' => '4:30 PM',
                        'plustwod' => '--'
                    ]);
                    
                $noti_token = "key=AAAADpmIKkI:APA91bEOn4spIMf-61k3Y7okH7998nwvVzeXJvGrJfMriiWGo6-VUMO6zJmMPLutJiwHJOyNljbrMHPZpCQLNsrTo4LvwHujwgVG-8YzBPdv5kRUdE3iCSi5L_bC2wqhtyA1QNdEh3hB";

                $data = [
                    'noti_data' => 'lottery'
                ];

                $notification = [
                    'title' => '2D (4:30 Number) is out!',
                    'body' => '4:30 Win Number is '.$threede[1].$threede[2]
                ];


                $noti_data = [
                    'priority' => 'HIGH',
                    'data' => $data,
                    'notification' => $notification,
                    'to' => '/topics/aungnamate'
                ];

                $ch2 = curl_init("https://fcm.googleapis.com/fcm/send");
                curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($noti_data));
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch2, CURLOPT_HTTPHEADER, [
                        'Authorization:'.$noti_token,
                        'Content-Type: application/json'
                    ]);
                
                $result2 = curl_exec($ch2);


        // $noti_token = "NjM1N2RjOTItNTIxMS00NDlhLTk3OTgtNWU5YjY3OTA3YmU2";

        // $contents = [
        //     'en' => '4:30 PM Win Number is'.$threed
        // ];

        // $headings = [
        //     'en' => '4:30 PM Win Number'
        // ];

        // $data2 = [
        //     'type' => 'all'
        // ];

        // $noti_data = [
        //     'app_id' => '5704f741-15dc-4b81-98f6-728b545b24c7',
        //     'included_segments' => 'Subscribed Users',
        //     'data' => $data2,
        //     'headings' => $headings,
        //     'contents' => $contents
        // ];

        // $ch2 = curl_init("https://onesignal.com/api/v1/notifications");
        // curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($noti_data));
        // curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch2, CURLOPT_HTTPHEADER, [
        //         'Authorization: Bearer ' . $noti_token,
        //         'Content-Type: application/json'
        //     ]);
        
        // $result2 = curl_exec($ch2);
                }
                else
                    {
                    DthreeD::insert([
                        '3D' => '---',
                        'set' => '---',
                        'value' => '---',
                        'modern' => '--',
                        'internet' => '--',
                        'date' => $date,
                        'tw_1206' => '--',
                        'day' => $day,
                        'time' => '4:30 PM',
                        'plustwod' => '--'
                    ]);
                }

                }
                })->weekdays()->timezone('Asia/Yangon')->at('16:31');
                
            // $schedule->call(function(){
            //         $date = Carbon::now('Asia/Yangon')->format('d.m.Y');
            //         $time = Carbon::now('Asia/Yangon')->format('g:i A');
            //         $day = Carbon::createFromFormat('d.m.Y',$date)->format('l');
                    
                    
            //         $winNo = DthreeD::where('date',$date)->where('time','4:31 PM')->value('3D');
            //         $winNoPlus = DthreeD::where('date',$date)->where('time','4:31 PM')->value('plustwod');
                    
    
            //         $loseSlips = BetSlip::where('forDate',$date)->where('forTime','4:30 PM')->whereIn('type',['D3D','D2D'])->where('status','ongoing')->get();
            //         $loseSlipsPlus = BetSlip::where('forDate',$date)->where('forTime','4:30 PM')->whereIn('type',['2DPLUS'])->where('status','ongoing')->get();
                    
            //         foreach ( $loseSlips as $loseSlip)
            //          {
            //              $loseSlip->update([
            //             'win_number' => $winNo,
            //             'status' => 'lose'
            //             ]);
                        
            //          }
            //          foreach ( $loseSlipsPlus as $loseSlipPlus)
            //          {
            //              $loseSlipPlus->update([
            //             'win_number' => $winNoPlus,
            //             'status' => 'lose'
            //             ]);
            //          }
            // })->weekdays()->timezone('Asia/Yangon')->at('16:45');
                
        }
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
