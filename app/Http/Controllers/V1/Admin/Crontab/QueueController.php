<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/2/20
 * Time: 22:02
 */

namespace App\Http\Controllers\V1\Admin\Crontab;


use App\Http\Controllers\V1\Admin\Base\BaseController;
use App\Logic\V1\Admin\Crontab\QueueLogic;

class QueueController extends BaseController
{
    /**
     * 队列列表
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function index()
    {
        $this->validate(null, [
            'status' => 'integer'
        ]);
        $queueLogic = new QueueLogic();
        $queueLogic->load($this->verifyData);
        return [
            'lists' => $queueLogic->index()
        ];
    }
}