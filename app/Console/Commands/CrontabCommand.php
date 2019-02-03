<?php

namespace App\Console\Commands;

use App\Console\Crontabs\AlpacaDaemon;
use Illuminate\Console\Command;

class CrontabCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crontab {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'crontab is a efficient timing tasks';

    /**
     * Create a new command instance.
     *
     * @return void
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
        // 启动状态验证
        $action = $this->argument('action');
        if (!in_array($action, ['start', 'stop', 'status'])) {
            $this->error('Error Arguments');
            exit;
        }
        /**
         * 定时任务启动
         */
        if ($action == 'start'){
            (new AlpacaDaemon())->start();
            exit;
        }

        /**
         * 定时任务停止
         */
        if ($action == 'stop'){
            (new AlpacaDaemon())->stop();
            exit;
        }

        /**
         * 查看定时任务
         */
        if ($action == 'status'){
            (new AlpacaDaemon())->status();
            exit;
        }
    }
}
