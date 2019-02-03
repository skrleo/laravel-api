<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/2/3
 * Time: 17:57
 */

namespace App\Http\Controllers\V1\Admin\Crontab;


use App\Http\Controllers\V1\Admin\Base\BaseController;
use App\Logic\V1\Admin\Crontab\DaemonLogic;

/**
 * 守护进程
 * Class DaemonController
 * @package App\Http\Controllers\V1\Admin\Crontab
 */
class DaemonController extends BaseController
{
    /**
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function start(){
        $this->validate(null, [
            'status' => 'integer'
        ]);
        $daemonLogic = new DaemonLogic();
        $daemonLogic->load($this->verifyData);
        if ($daemonLogic->start()){
            return [];
        }
    }



}