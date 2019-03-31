<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/2/11
 * Time: 12:17
 */

namespace App\Http\Middleware;

use App\Logic\Exception;
use App\Logic\V1\Admin\Rbac\ManageLogic;
use App\Logic\V1\Login\AccountLogic;
use DdvPhp\DdvRestfulApi\Exception\RJsonError;
use \Illuminate\Http\Request;
use \Closure;

class AdminManage
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param null $guard
     * @throws Exception
     * @throws RJsonError
     * @throws \App\Model\Exception
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (!AccountLogic::isLogin()) {
            throw new RJsonError(AccountLogic::isLogin(), 'NO_ACCOUNT_LOGIN');
        }
        if (!ManageLogic::isLoginManage()) {
            throw new RJsonError('没有管理权限', 'NO_MANAGE');
        }
        if(!ManageLogic::getManageState(AccountLogic::getLoginUid())){
            throw new Exception('账号异常', 'ERROR_MANAGE_STATE');
        }
        return $next($request);
    }
}