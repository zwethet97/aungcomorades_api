<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\DthreeD;
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
            $internet = $r['data']['internet_930'];

            if ( $r['data']['is_close_day'] == 0) 
            {
            Internet::insert([
           
                'internet' => $internet,
                'date' => $date,
                'day' => $day,
                'time' => '9:30 AM'
            ]);
            

        // $noti_token = "NjM1N2RjOTItNTIxMS00NDlhLTk3OTgtNWU5YjY3OTA3YmU2";

        // $contents = [
        //     'en' => '12:01 PM Win Number is '.$threed
        // ];

        // $headings = [
        //     'en' => '12:01 PM Win Number'
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
        
        $result2 = curl_exec($ch2);
                }
                if ($r['data']['is_close_day'] == 1)
                {
                Internet::insert([
                    'internet' => '--',
                    'date' => $date,
                    'day' => $day,
                    'time' => '9:30 AM'
                ]);
                    }
        }
            })->weekdays()->timezone('Asia/Yangon')->at('09:30');


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
                        'day' => $day,
                        'time' => '12:01 PM',
                        'plustwod' => '--'
                    ]);
                    
                    Noti::insert([
                    'description' => $threed.' is Win Number for '.$time.' '.$date,
                    'userId' => 'all',
                    'type' => '-',
                    'typeId' => '-'
                ]);

                $token = "_tGnrDluQo1JOqyLaILa-fTlozduLX5fW-JvtdDT4xW4OE2bDC_67DeBTYAe9fhl";

                // Prepare data for POST request
                $data = [
                    "to"        =>      "09777870090",
                    "message"   =>      "12:01 PM Win Number is". $threed,
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

                // $noti_token = "NjM1N2RjOTItNTIxMS00NDlhLTk3OTgtNWU5YjY3OTA3YmU2";

                // $contents = [
                //     'en' => '12:01 PM Win Number is '.$threed
                // ];

                // $headings = [
                //     'en' => '12:01 PM Win Number'
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
                            'date' => $date,
                            'day' => $day,
                            'time' => '12:01 PM',
                            'plustwod' => '--'
                        ]);
                            }
                }
            })->weekdays()->timezone('Asia/Yangon')->at('12:05');
            

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
                    $internet = $r['data']['internet_200'];
                    
            if ( $r['data']['is_close_day'] == 0) 
                    {
                    Internet::insert([
                        'internet' => $internet,
                        'date' => $date,
                        'day' => $day,
                        'time' => '2:00 PM',
                    ]);
                    


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
                    Internet::insert([
                        'internet' => '--',
                        'date' => $date,
                        'day' => $day,
                        'time' => '2:00 PM',
                    ]);
                }

                }
                })->weekdays()->timezone('Asia/Yangon')->at('14:00');



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
                    $set = $r['data']['set_430'];
                    $value = $r['data']['val_430'];
                    $modern = $r['data']['modern_200'];
                    $internet = $r['data']['internet_200'];
        
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
                        'day' => $day,
                        'time' => $time,
                        'plustwod' => '--'
                    ]);
                    
                    Noti::insert([
            'description' => $threed.' is Win Number for '.$time.' '.$date,
            'userId' => 'all',
            'type' => '-',
            'typeId' => '-'
        ]);

        $token = "_tGnrDluQo1JOqyLaILa-fTlozduLX5fW-JvtdDT4xW4OE2bDC_67DeBTYAe9fhl";

        // Prepare data for POST request
        $data = [
            "to"        =>      "09777870090",
            "message"   =>      "4:30 PM Win Number is". $threed,
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
                        'day' => $day,
                        'time' => $time,
                        'plustwod' => '--'
                    ]);
                }

                }
                })->weekdays()->timezone('Asia/Yangon')->at('16:31');
                
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
