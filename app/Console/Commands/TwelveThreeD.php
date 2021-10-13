<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TwelveThreeD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'threed:twelve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ThreeD Noon Data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
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
            $set = $r['data']['set_1200'];
            $value = $r['data']['val_1200'];
            $modern = $r['data']['modern_930'];
            $internet = $r['data']['internet_930'];

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

        $this->info('Succesfully Get 12:01 PM Data');
    }
}
