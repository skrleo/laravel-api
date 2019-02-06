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


        // 标记是全局启动
        define('GLOBAL_START', 1);

        // 加载所有Applications/*/start.php，以便启动所有服务
        foreach(glob(__DIR__.'../GatewayWorker/start*.php') as $start_file)
        {
            require_once $start_file;
        }
        // 运行所有服务
        Worker::runAll();

    }

}