<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\DthreeD;
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
        $schedule->command('threed:twelve')
        ->weekdays()->timezone('Asia/Yangon')->at('12:01');

            $schedule->call(function(){
            // $client = new Client();
            // $crawler = $client->request('GET','https://marketdata.set.or.th/mkt/marketsummary.do?language=en&country=US');
    
            // $set = $crawler->filter('.table-info tr td')->eq(1)->text();
            // $value = $crawler->filter('.table-info tr td')->eq(7)->text();
            $date = Carbon::now('Asia/Yangon')->format('d-m-Y');
            $time = Carbon::now('Asia/Yangon')->format('g:i A');
            $day = Carbon::createFromFormat('d-m-Y',$date)->format('l');
            
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
    
                DthreeD::insert([
                    '3D' => $threed,
                    'set' => $set,
                    'value' => $value,
                    'modern' => $modern,
                    'internet' => $internet,
                    'date' => $date,
                    'day' => $day,
                    'time' => $time
                ]);
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
