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
     * @var DdvFile
     */
    protected $upload;

    public function __construct()
    {
        method_exists(parent::class, '__construct') && parent::__construct();
        $this->fileConfigInit();
    }

    private function fileConfigInit()
    {
        $config = [
            'uid' => '0'
        ];
        // 使用存储驱动
        $drivers = new AliyunOssDrivers(config('aliyun.oss'));
        // 数据库模型
        $database = new LaravelMysqlDatabase();
        $this->upload = new DdvFile($config, $drivers, $database);
    }
    ## 获取分块大小
    public function filePartSize(Request $request)
    {
        return [
            'data' =>
                $this->upload->getPartSize($request->only(['fileSize', 'fileType', 'deviceType']))
        ];
    }

    public function fileId(Request $request)
    {
        $input = $request->only(
            $this->upload->getFileIdInputKeys([
                'authType',
                'manageType',
                // 上传目录
                'directory'
            ])
        );
        $directorys = config('upload.directory');
        $input['directory'] = empty($directorys[$input['authType']]) ? '/upload/other/' : $directorys[$input['authType']];
//    switch($input['authType']){
//    }
        return [
            'data' =>
                $this->upload->getFileId($input)
        ];
    }

    public function filePartInfo(Request $request)
    {
        $input = $request->only(
            [
                'fileId',
                'fileMd5',
                'fileSha1',
                'fileCrc32'
            ]
        );
        return [
            'data' =>
                $this->upload->getFilePartInfo($input)
        ];
    }

    public function filePartMd5(Request $request)
    {
        $input = $request->only(
            [
                'fileId',
                'fileMd5',
                'fileSha1',
                'fileCrc32',
                'md5Base64',
                'partLength',
                'partNumber'
            ]
        );
        return [
            'data' =>
                $this->upload->getFilePartMd5($input)
        ];

    }
    public function complete(Request $request)
    {
        $input = $request->only(
            [
                'fileId',
                'fileMd5',
                'fileSha1',
                'fileCrc32'
            ]
        );
        $data = $this->upload->complete($input);
        return [
            'data' => $data

        ];
    }

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