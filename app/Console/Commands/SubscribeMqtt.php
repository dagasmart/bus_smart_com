<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MqttService;

class SubscribeMqtt extends Command
{
    protected $signature = 'mqtt:subscribe {topic}';
    protected $description = 'Subscribe to MQTT topic';

    public function handle(): void
    {
        $topic = $this->argument('topic');

        $mqtt = new MqttService();
        $mqtt->subscribe($topic, function ($topic, $message) {
            $this->info("Received message on topic [{$topic}]: {$message}");
            // 在这里处理接收到的消息
        });
    }
}
