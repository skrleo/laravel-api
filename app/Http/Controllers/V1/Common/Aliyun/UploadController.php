<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/30
 * Time: 16:06
 */

namespace App\Http\Controllers\V1\Common\Aliyun;

use App\Http\Controllers\Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use OSS\OssClient;
use OSS\Core\OssException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DdvPhp\DdvFile;
use DdvPhp\DdvFile\Database\LaravelMysqlDatabase;
use DdvPhp\DdvFile\Drivers\AliyunOssDrivers;

class UploadController extends Controller
{
    /**
     * 图片上传
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function uploadImg(Request $request){
        if ($request->isMethod('post')) {
            $file = $request->file('file');
            // 文件是否上传成功
            if ($file->isValid()) {
                // 获取文件相关信息
                $extension = $file->getClientOriginalExtension();
                // 上传文件
                $fileName = date('YmdHis') . uniqid() . '.' . $extension;
                //图片保存路径
                if (!file_exists(storage_path('upload/images/'))) {
                    mkdir(storage_path('upload/images/'),0755,true);
                }
                $file->move(storage_path('upload/images/'), $fileName);
                $filePath = storage_path('upload/images/') . $fileName;
                // 上传到阿里云 OSS存储
                try{
                    $ossClient = new OssClient(config('aliyun.oss.accessKeyId'), config('aliyun.oss.accessKeySecret'), config('aliyun.oss.endpoint'));
                    $ossClient->uploadFile(config('aliyun.oss.bucket'), $fileName, $filePath);
                } catch(OssException $e) {
                    throw new Exception('文件上传失败','FILE_UPLOAD_FAIL');
                }
                unlink($filePath);
            }
        }
        return [
            'data' => [
                //https://img.17wangku.com/201902030238145c565416c7fac.png
                'filePath' =>  config('aliyun.oss.urlRoot'). $fileName
            ]
        ];
    }
}