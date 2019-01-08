<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2018/12/17
 * Time: 11:18
 */

namespace App\Http\Controllers\V1\Login;
use App\Http\Controllers\Controller;
use App\Logic\V1\Common\RegisterLogic;
use App\Model\V1\User\UserAccountModel;
use Illuminate\Contracts\Session\Session;

class RegisterController extends Controller
{
    /**
     * @return int
     */
    public function register(){
        return 1111;
    }
}