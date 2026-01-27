<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SubscribeMqtt extends Command
{

    protected $signature = 'mqtt:subscribe {topic}';
    protected $description = 'Subscribe to MQTT topic';

    public function handle()
    {
        $topic = $this->argument('topic');

        $mqtt = new \App\Services\MqttService();
        $mqtt->connect();

        $mqtt->subscribe($topic, function ($topic, $message) {
            $this->info("Received message on topic [{$topic}]: {$message}");
            // 在这里处理接收到的消息
        });

        $mqtt->loop();
    }

}
