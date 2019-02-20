<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/2/2
 * Time: 18:41
 */

namespace App\Http\Controllers\V1\Admin\Base;


use App\Http\Controllers\Controller;
use App\Jobs\BaseJob;
use App\Jobs\SendReminderEmail;
use App\Logic\V1\Admin\Base\BaseLogic;
use Faker\Provider\Base;

class BaseController extends Controller
{
    /**
     * 获取用户权限节点
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     * @throws \DdvPhp\DdvUtil\Exception
     */
    public function index(){
        $this->validate(null, [
            'uid' => 'required|integer'
        ]);
        $baseLogic = new BaseLogic();
        $baseLogic->load($this->verifyData);
        return [
            'lists' => $baseLogic->nodeLists()
        ];
    }

    /**
     *
     */
    public function test(){
        dispatch(new BaseJob())->onQueue('testQueue');
        BaseJob::dispatch()->delay(10);
    }
}