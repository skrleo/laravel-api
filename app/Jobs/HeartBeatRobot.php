<?php

namespace App\Jobs;

use App\Model\V1\Robot\HeartBeatModel;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class HeartBeatRobot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $wxid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($wxid)
    {
        //
        $this->wxid = $wxid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $isDoRun = true;
        do {
            $client = new Client();
            $res = $client->request('POST', 'http://106.15.235.187:1925/api/Login/HeartBeat/' .$this->wxid);
            $res = json_decode($res->getBody()->getContents(), true);
            if ($res["Success"] == false){
                $isDoRun = false;
                Log::info("[" . date("Y-m-d H:i:s") . "]|error Info:" . $res["Message"]);
            }
            sleep(149);
        } while ($isDoRun);
    }
}
