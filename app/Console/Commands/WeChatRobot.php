<?php

namespace App\Console\Commands;

use App\Http\Controllers\V1\Admin\Wechat\Vbot\VbotController;
use Hanson\Vbot\Foundation\Vbot;
use Hanson\Vbot\Message\Text;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Vbot\WebServer\WebServer;

class WeChatRobot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vbot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * 启动微信机器人
     * Execute the console command.
     *
     * @return mixed
     * @throws \Hanson\Vbot\Exceptions\ArgumentException
     */
    public function handle()
    {
        $vbot = new Vbot(config('vbot'));
        WebServer::register();

        $vbot->messageHandler->setHandler(function ($message) {
            Text::send($message['from']['UserName'], 'Hi, I\'m Vbot!');
        });

        $vbot->server->serve();
    }
}
