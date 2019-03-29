<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/29
 * Time: 19:11
 */

namespace App\Model\V1\Base;


use App\Model\Model;

class OperationLogModel extends Model
{
    protected $table = 'operation_log';

    protected $primaryKey = 'operation_log_id';
}