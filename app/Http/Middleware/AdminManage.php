<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/2/11
 * Time: 12:17
 */

namespace App\Http\Middleware;

use App\Logic\Exception;
use App\Logic\V1\Login\AccountLogic;
use App\Model\V1\Rbac\Purview\ManageModel;
use DdvPhp\DdvRestfulApi\Exception\RJsonError;
use \Illuminate\Http\Request;
use \Closure;

class AdminManage
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param null $guard
     * @throws RJsonError
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {

    }
}