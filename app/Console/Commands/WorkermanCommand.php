<?php

namespace App\Console\Commands;

use GatewayWorker\Gateway;
use GatewayWorker\Register;
use Illuminate\Console\Command;
use \GatewayWorker\BusinessWorker;
use Workerman\Worker;
use GatewayWorker\Lib\Gateway as WsSender;

class WorkermanCommand extends Command
{
    protected $webSocket;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ws {action} {--d}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'workerman server';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 检查OS
        if (strpos(strtolower(PHP_OS), 'win') === 0) {
            $this->error("Sorry, not support for windows.\n");
            exit;
        }

        // 检查扩展
        if (!extension_loaded('pcntl')) {
            $this->error("Please install pcntl extension. See http://doc3.workerman.net/appendices/install-extension.html\n");
            exit;
        }
        if (!extension_loaded('posix')) {
            $this->error("Please install posix extension. See http://doc3.workerman.net/appendices/install-extension.html\n");
            exit;
        }

        //因为workerman需要带参数 所以得强制修改
        global $argv;
        $action = $this->argument('action');
        if (!in_array($action, ['start', 'stop', 'status'])) {
            $this->error('Error Arguments');
            exit;
        }
        $argv[0] = 'ws';
        $argv[1] = $action;
        $argv[2] = $this->option('d') ? '-d' : '';

        switch ($argv[1]) {
            case 'start':
                $this->start();
                break;
            case 'stop':
                break;
            case 'restart':
                break;
            case 'reload':
                break;
            case 'status':
                break;
            case 'connections':
                break;
        }

    }

    /**
     * 启动workerman 连接
     */
    public function start(){
        $this->startGateWay();
        $this->startBusinessWorker();
        $this->startRegister();
        // 运行所有服务
        Worker::runAll();
    }

    /**
     * 启动Gateway服务
     */
    public function startGateWay(){
        // gateway 进程，这里使用Text协议，可以用telnet测试
        $gateway = new Gateway("tcp://0.0.0.0:8282");
        // gateway名称，status方便查看
        $gateway->name = 'YourAppGateway';
        // gateway进程数
        $gateway->count = 4;
        // 本机ip，分布式部署时使用内网ip
        $gateway->lanIp = '127.0.0.1';
        // 内部通讯起始端口，假如$gateway->count=4，起始端口为4000
        // 则一般会使用4000 4001 4002 4003 4个端口作为内部通讯端口
        $gateway->startPort = 2900;
        // 服务注册地址
        $gateway->registerAddress = '127.0.0.1:1238';
    }

    /**
     * 启动BusinessWorker服务
     */
    public function startBusinessWorker(){
        // bussinessWorker 进程
        $worker = new BusinessWorker();
        // worker名称
        $worker->name = 'YourAppBusinessWorker';
        // bussinessWorker进程数量
        $worker->count = 4;
        // 服务注册地址
        $worker->registerAddress = '127.0.0.1:1238';
    }

    /**
     * 启动Register服务
     */
    public function startRegister(){
        // register 必须是text协议
        $register = new Register('text://0.0.0.0:1238');
    }
}