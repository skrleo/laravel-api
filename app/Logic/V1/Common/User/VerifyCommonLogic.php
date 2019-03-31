<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/31
 * Time: 2:06
 */

namespace App\Logic\V1\Common\User;

use App\Logic\Exception;
use Gregwar\Captcha\CaptchaBuilder;
use App\Logic\LoadDataLogic;

class VerifyCommonLogic extends LoadDataLogic
{
    protected $sessionKey = '';

    protected $verifyGuid = '';

    //图形验证码
    protected $imgVerify = '';

    /**
     * 生成验证码
     * @param int $length
     * @param string $charset
     * @return string
     */
    public static function generateVerifyCode($length = 5, $charset = '')
    {
        $phrase = '';
        if (empty($charset)) {
            $a = str_split('abcdefghijklmnpqrstuvwxyz');
            $b = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
            $c = str_split('1234567890');
            $chars = array_merge($a, $b, $c);
        } else {
            $chars = str_split($charset);
        }
        for ($i = 0; $i < $length; $i++) {
            $phrase .= $chars[array_rand($chars)];
        }

        return $phrase;
    }

    /**
     * 检验图形验证码
     * @throws Exception
     */
    public function checkImgVerify()
    {
        if (empty($this->sessionKey) || empty($this->verifyGuid) || empty($this->imgVerify)) {
            throw new Exception('缺少参数，无法验证', 'CHECK_IMG_VERIFY_FAIL');
        }
        $codeCheck = \Session::get($this->sessionKey . '.img.verify.code', null);

        $verifyType = null;
        if (empty($codeCheck)) {
            throw new Exception('图形验证码已经过期', 'IMG_VERIFY_TIMEOUT');
        }
        if (md5($this->verifyGuid . strtolower($this->imgVerify)) !== $codeCheck) {
            throw new Exception('图形验证码错误', 'IMG_VERIFY_ERROR');
        }
    }

    /**
     * 把图形验证码返给调用者
     * @return string
     */
    public function getImgVerifyBase64()
    {
        if (empty($this->imgVerify)) {
            $this->imgVerify = self::generateVerifyCode(4);
        }
        $res = self::getImgVerifyRaw($this->imgVerify);
        \Session::put($this->sessionKey . '.img.verify.code', md5($this->verifyGuid . strtolower($res['code'])));

        return 'data:image/jpeg;base64,' . base64_encode($res['raw']);
    }

    public static function getImgVerifyRaw($phrase = null)
    {
        $phrase = empty($phrase) ? null : (string)$phrase;
        $builder = new CaptchaBuilder($phrase);
        //可以设置图片宽高及字体
        $builder->build($width = 108, $height = 40, $font = null);
        $phrase = $builder->getPhrase();
        @ob_start();
        $image_data_old = ob_get_contents();
        @ob_end_clean();
        @ob_start();
//
        $builder->output();
        $imageRaw = ob_get_contents();

        @ob_end_clean();
        echo $image_data_old;

        return [
            'code' => $phrase,
            'raw' => $imageRaw
        ];
    }


}