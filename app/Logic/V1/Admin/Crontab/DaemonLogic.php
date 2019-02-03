<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/2/3
 * Time: 18:24
 */

namespace App\Logic\V1\Admin\Crontab;


use App\Logic\LoadDataLogic;

class DaemonLogic extends LoadDataLogic
{
    protected $daemonJson = __DIR__ .'/deamon.json';

    /**
     * 启动守护进程
     */
    public function start(){
        $data = json_decode(file_get_contents($this->daemonJson,true));
        if(empty($data)){
            $data['code'] = '1001';
        }
        if($data['code'] == "1000" ){
            //die("Error - exit,   Already running !");
            return;
        }

        $data['code']="1000";
        $data['message']="Start";
        file_put_contents($this->daemonJson,json_encode($data,true),LOCK_EX);

        ignore_user_abort(true);     // 忽略客户端断开
        set_time_limit(0);           // 设置执行不超时

        while(true){
            $data = json_decode(file_get_contents($this->daemon_json) , true);
            if(empty($data) || empty($data['code']) || $data['code'] == "1001" ){
                break;
            }

            if(!empty($this->events)){
                foreach ($this->events as $e){
                    $e();
                }
            }

            $data['message'] = date("Y-m-d H:i:s" ,time())." : Working ...";
            file_put_contents($this->daemon_json, json_encode($data), LOCK_EX);
            sleep(1);
        }
        $this->stop();
    }
}