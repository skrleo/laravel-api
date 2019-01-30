<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/30
 * Time: 16:28
 */

namespace App\Logic\V1\Common\Aliyun;


use App\Logic\Exception;
use App\Logic\LoadDataLogic;
use OSS\Core\OssException;
use OSS\OssClient;

class UploadLogic extends LoadDataLogic
{
    public $file = '';

    public $baseImg = '';

    /**
     *
     */
    public function base64(){
        //  $base_img是获取到前端传递的src里面的值，也就是我们的数据流文件
        $base_img = str_replace('data:image/jpg;base64,', '', $this->baseImg);
        //  设置文件路径和文件前缀名称
        $path = "./";
        $prefix='nx_';
        $output_file = $prefix.time().rand(100,999).'.jpg';
        $path = $path.$output_file;
        //  创建将数据流文件写入我们创建的文件内容中
        $ifp = fopen( $path, "wb" );
        fwrite( $ifp, base64_decode( $base_img) );
        fclose( $ifp );
        // 第二种方式
        // file_put_contents($path, base64_decode($base_img));
        // 输出文件
        return $output_file;
    }
    /**
     * 图片上传
     * @return array
     * @throws Exception
     */
    public function uploadImg(){
        $file1 = storage_path('1.txt');
        $fp = fopen($file1, 'w');
        fwrite($fp, $this->file);
        fclose($fp);
//        $extension = pathinfo( parse_url( $this->file, PHP_URL_PATH ), PATHINFO_EXTENSION );
//        $fileName =  date("YmdHis").rand(100, 999) . '.' . $extension;
//        try{
//            $ossClient = new OssClient(config('aliyun.oss.accessKeyId'), config('aliyun.oss.accessKeySecret'), config('aliyun.oss.endpoint'));
//            $ossClient->uploadFile(config('aliyun.oss.bucket'), $fileName, $this->file);
//        } catch(OssException $e) {
//            throw new Exception('文件上传失败','FILE_UPLOAD_FAIL');
//        }
//        return [
//            'fileUrl' => config('aliyun.oss.urlRoot').$fileName
//        ];
    }
}
