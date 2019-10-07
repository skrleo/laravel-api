<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/10/1
 * Time: 19:10
 */

namespace App\Jobs;

use App\Model\V1\Crontab\CrontabModel;
use GuzzleHttp\Client;
use Hhxsv5\LaravelS\Swoole\Timer\CronJob;

class ServiceInit extends CronJob
{
    protected $i = 0;
    // !!! 定时任务的`interval`和`isImmediate`有两种配置方式（二选一）：一是重载对应的方法，二是注册定时任务时传入参数。
    // --- 重载对应的方法来返回配置：开始
    public function interval()
    {
        return 1000;// 每1秒运行一次
    }
    public function isImmediate()
    {
        return false;// 是否立即执行第一次，false则等待间隔时间后执行第一次
    }

    public function run()
    {
        // TODO: Implement run() method.
        CrontabModel::getHump()->each(function ($model){
            if ($model->status == 1){
                $client = new Client();
                $res = $client->request('GET', $model->action);
                var_dump(date('y-m-d H:i:s',time()).':'.$res->getBody());
            }
        });
    }
}