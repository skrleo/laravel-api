<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/2/3
 * Time: 15:29
 */

namespace App\Console\Crontabs;


use App\Model\V1\Crontab\CrontabModel;

/**
 * 守护进程
 * Class AlpacaDaemon
 * @package App\Console\Crontabs
 */
class AlpacaDaemon
{
    private $daemon_json = __DIR__ . '/deamon.json';

    private static $instance;

    private $events = [];

    public static function daemon()
    {
        return self::getInstance();
    }

    private static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new self();
            self::$instance->daemon_json = __DIR__ . '/deamon.json';
        }
        return self::$instance;
    }

    public function setDaemon($daemon_json)
    {
        $this->daemon_json = $daemon_json;
        return $this;
    }

    public function setEvents(array $events)
    {
        $this->events = $events;
        return $this;
    }

    /**
     * @return array|mixed
     */
    public function status()
    {
        $data = json_decode(file_get_contents($this->daemon_json),true);
        if(empty($data)){
            $data = array();
        }
        return $data;
    }

    /**
     * code是1001,表示后台进程已经启动
     * @return mixed
     */
    public function stop()
    {
        $data = new \stdClass();
        $data->code="1001";
        $data->message="Stop at:".date("Y-m-d H:i:s" ,time());
        file_put_contents($this->daemon_json,json_encode($data),LOCK_EX);

        $result["result_code"] = "1";
        $result["result_message"] = "操作成功";
        return $result;
    }

    /**
     * code是1000时候，表示后台进程未启动
     */
    public function start()
    {
        $data = json_decode(file_get_contents($this->daemon_json) , true);
        if(empty($data)){
            $data['code']="1001";
        }

        if($data['code'] == "1000" ){
            //die("Error - exit,   Already running !");
            return;
        }

        $data['code']="1000";
        $data['message']="Start";
        file_put_contents($this->daemon_json,json_encode($data),LOCK_EX);

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