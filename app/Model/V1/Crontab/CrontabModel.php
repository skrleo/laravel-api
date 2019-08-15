<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/2/3
 * Time: 18:02
 */

namespace App\Model\V1\Crontab;


use App\Model\Model;

class CrontabModel extends Model
{
    protected $table = 'crontab';

    protected $primaryKey = 'crontab_id';

    // 任务暂停状态
    const TASK_QUEUE_STOP = 0;
    // 任务运行状态
    const TASK_QUEUE_START = 1;

    /**
     * 运行定时任务队列
     */
    public function runCrontab(){
        
    }
}