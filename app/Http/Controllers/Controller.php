<?php

namespace App\Http\Controllers;

use DdvPhp\DdvRestfulApi\Exception\RJsonError;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use \DdvPhp\DdvUtil\Laravel\Controller as DdvController;
use App\Http\Middleware\ClientIp;

class Controller extends BaseController
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use DispatchesJobs,DdvController,ValidatesRequests;

    /**
     * Validate the given request with the given rules.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  array $rules
     * @param  array $messages
     * @param  array $customAttributes
     * @return void
     * @throws RJsonError
     */
    public function validate($data = null, array $rules, array $messages = [], array $customAttributes = [])
    {
        if (empty($data)){
            $request = ClientIp::getRequest();
            $data = $request->all();
        }elseif (is_array($data)){
            $request = ClientIp::getRequest();
            $data = array_merge($request->input(), $data);
        }else{
            $data = [];
        }
        $validator = $this->getValidationFactory()->make($data, $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            foreach ($validator->failed() as $key => $item){
                throw new RJsonError($key.'验证错误['.json_encode($item).']', strtoupper(\DdvPhp\DdvUtil\String\Conversion::humpToUnderline($key)) .'_ERROR');
            }
        }
        $this->verifyData = [];
        foreach ($rules as $key => $value){
            ((!empty($data[$key]) || isset($data[$key]) && is_numeric($data[$key])))? $this->verifyData[$key] = $data[$key] : null;
        }
    }
}
