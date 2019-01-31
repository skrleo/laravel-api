<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/30
 * Time: 16:06
 */

namespace App\Http\Controllers\V1\Common\Aliyun;

use App\Http\Controllers\Exception;
use OSS\OssClient;
use OSS\Core\OssException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DdvPhp\DdvFile;
use DdvPhp\DdvFile\Database\LaravelMysqlDatabase;
use DdvPhp\DdvFile\Drivers\AliyunOssDrivers;

class UploadController extends Controller
{
    public $file = '';
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
        $imgBase64 = $request->input('file');
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/',$imgBase64,$res)) {
            //图片保存路径
            $new_file = storage_path("images/".date('Ymd',time()).'/');
            if (!file_exists($new_file)) {
                mkdir($new_file,0755,true);
            }
            //图片名字 + 获取图片类型
            $new_file = $new_file.time().'.'.$res[2];
            if (!file_put_contents($new_file,base64_decode(str_replace($res[1],'', $imgBase64)))) {
               throw new Exception('图片保存失败','UPLOAD_IMAGE_FAIL');
            }
            return [];
        }
    }
}