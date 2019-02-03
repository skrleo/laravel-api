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

}