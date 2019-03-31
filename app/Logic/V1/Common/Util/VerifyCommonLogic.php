<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/31
 * Time: 11:15
 */

namespace App\Logic\V1\Common\Util;

use DdvPhp\DdvRestfulApi\Exception\RJsonError;
use Gregwar\Captcha\CaptchaBuilder;
use App\Logic\LoadDataLogic;

class VerifyCommonLogic extends LoadDataLogic
{
    /**
     * 生成验证码
     * @param int $length
     * @param string $charset
     * @return string
     */
    public static function generateVerifyCode($length = 5, $charset = 'abcdefghjkmnpqrstuvwxyz23456789'){
        $phrase = '';
        $chars = str_split($charset);

        for ($i = 0; $i < $length; $i++) {
            $phrase .= $chars[array_rand($chars)];
        }

        return $phrase;
    }

    /**
     * 检验图形验证码
     * @param $sessionKey
     * @param $verifyGuid
     * @param $code
     * @throws RJsonError
     */
    public static function checkImgVerify($sessionKey, $verifyGuid, $code){
        if (empty($verifyGuid)){
            throw new RJsonError('参数错误', 'PARAMS_ERROR');
        }
        $codeCheck = \Session::get($sessionKey.'.img.verify.code', null);
        $verifyType = null;
        if (empty($code)){
            throw new RJsonError('图形验证码已经过期', 'IMG_VERIFY_TIMEOUT');
        }
        if (md5($verifyGuid.$code) !== $codeCheck){
            throw new RJsonError('图形验证码错误', 'IMG_VERIFY_ERROR');
        }
    }

    //把图形验证码返给调用者
    public static function getImgVerifyBase64($sessionKey, $verifyGuid, $code){

        if (empty($code)){
            $code = VerifyCommonLogic::generateVerifyCode(4);
        }
        $res = self::getImgVerifyRaw($code);
        \Session::put($sessionKey.'.img.verify.code', md5($verifyGuid.$res['code']));

        return 'data:image/jpeg;base64,' .base64_encode ($res['raw']);
    }

    public static function getImgVerifyRaw($phrase = null){
        $phrase = empty($phrase)?null:(string)$phrase;
        $builder = new CaptchaBuilder($phrase);
        //可以设置图片宽高及字体
        $builder->build($width = 108, $height = 40, $font = null);
        $phrase = $builder->getPhrase();
        @ob_start ();
        $image_data_old = ob_get_contents ();
        @ob_end_clean ();
        @ob_start ();

        $builder->output();
        $imageRaw = ob_get_contents ();

        @ob_end_clean ();
        echo $image_data_old;

        return [
            'code'=>$phrase,
            'raw'=>$imageRaw
        ];
    }

    /**
     * 设置缓存
     */
    public function checkShowCode($data)
    {
        $key = (isset($data['account'])) ? $data['account'] : (isset($data['phone']) ? $data['phone'] : '');
        $state = $this->getCacheShowCode($key);
        return ['isShow' => $state == true ? 1 : 0];
    }

    /**
     * @param $key
     * @param $value
     * 通过设置错误的次数
     */
    public static function setCacheShowCode($key)
    {
        try{
            $cache = \Cache::get($key);
            if (empty($cache)) {
                /**
                 * 为空的话，直接保存时间是一天
                 */
                $minutes = \Carbon\Carbon::now()->addMinutes(60*24);
                \Cache::put($key,1,$minutes);
                return true;
            }
            \Cache::increment($key,1);
        }catch (\Exception $exception) {
        }
    }

    /**
     * @param $key
     * 清除缓存
     */
    public static function clearCache($key)
    {
        try{
            \Cache::forget($key);
        }catch (\Exception $exception) {

        }
    }
    /**
     * @param $key
     * 保存缓存的次数
     */
    public function getCacheShowCode($key)
    {
        $cacheData = \Cache::get($key);
        if (empty($cacheData)) {
            return false;
        }
        return (int)$cacheData > 2 ? true : false;
    }

}