<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/4/9
 * Time: 21:45
 */

namespace App\Http\Controllers\V1\Common\Open;


use App\Http\Controllers\Controller;
use App\Logic\V1\Common\Open\OauthLogic;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function handleLogin(Request $request){
        $query = $request->input('query');
        try{
            if (is_array($query)){
                @$_GET = array_merge($query, $_GET);
            }
        }catch (\Error $e){}
        $this->validate(null, [
            'appType' => 'required|string',
            'appName' => 'required|string',
            'callback' => 'required|string'
        ]);
        \Log::info($this->verifyData);
        $OaLogic = new OauthLogic(array_merge(
            $this->verifyData,
            [
                'query'=>$query
            ]
        ));
        return [
            'data'=>$OaLogic->handleLogin()
        ];
    }
}