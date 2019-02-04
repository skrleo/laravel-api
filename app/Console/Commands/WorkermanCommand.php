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

        // 启动BusinessWorker服务 -- 必须是text协议
        new Register('text://0.0.0.0:' . config('gateway.register.port'));

        // 启动BusinessWorker服务
        $worker                  = new BusinessWorker();
        $worker->name            = config('gateway.worker.name');
        $worker->count           = config('gateway.worker.count');
        $worker->registerAddress = config('gateway.register.host') . ':' . config('gateway.register.port');
        $worker->eventHandler    = 'Console\Commands\WorkermanCommand';

        // 启动Gateway服务
        $gateway                  = new Gateway("websocket://0.0.0.0:" . config('gateway.port'));
        $gateway->name            = config('gateway.gateway.name');
        $gateway->count           = config('gateway.gateway.count');
        $gateway->lanIp           = config('gateway.gateway.lan_ip');
        $gateway->startPort       = config('gateway.gateway.startPort');
        $gateway->registerAddress = config('gateway.register.host') . ':' . config('gateway.register.port');
        $gateway->pingInterval    = 10;
        $gateway->pingData        = '{"action":"sys/ping","data":"0"}';

        /*
        // 当客户端连接上来时，设置连接的onWebSocketConnect，即在websocket握手时的回调
        $gateway->onConnect = function($connection)
        {
            $connection->onWebSocketConnect = function($connection , $http_header)
            {
                // 可以在这里判断连接来源是否合法，不合法就关掉连接
                // $_SERVER['HTTP_ORIGIN']标识来自哪个站点的页面发起的websocket链接
                if($_SERVER['HTTP_ORIGIN'] != 'http://kedou.workerman.net')
                {
                    $connection->close();
                }
                // onWebSocketConnect 里面$_GET $_SERVER是可用的
                // var_dump($_GET, $_SERVER);
            };
        };
        */

        // 运行所有服务
        Worker::runAll();
    }
}