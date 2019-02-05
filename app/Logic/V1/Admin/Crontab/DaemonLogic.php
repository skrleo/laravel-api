<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/2/3
 * Time: 18:24
 */

namespace App\Logic\V1\Admin\Crontab;


use App\Console\Crontabs\AlpacaDaemon;
use App\Console\Crontabs\AlpacaWorker;
use App\Logic\LoadDataLogic;

class DaemonLogic extends LoadDataLogic
{
    protected $daemonJson = __DIR__ .'/deamon.json';

    /**
     * 开始守护进程
     */
    public function start(){
        //在守护进程中注入定时任务
        $events = ['0'=>function(){
            AlpacaWorker::worker()->action(['REQUEST_URI'=>"/crontab/index/task"]);
        }];
        AlpacaDaemon::daemon()->setEvents($events);
        AlpacaDaemon::daemon()->start();
        return [];
    }

    /**
     * 停止定时任务的守护进程
     * @return mixed
     */
    public function stop(){
        $result['data'] = AlpacaDaemon::daemon()->stop();
        return $result;
    }

    /**
     * 执行定时任务
     * @return mixed
     */
    public function task(){
        //执行定时任务
        $result['data'] = AlpacaCrontab::crontab()->doTask();
        return $result;
    }
}