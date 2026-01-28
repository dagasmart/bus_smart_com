<?php

namespace App\Services;

use PhpMqtt\Client\Facades\MQTT;


class MqttService
{
    protected MQTT $client;

    public function __construct()
    {
        $this->client = new Mqtt();
        return $this;
    }

    public function publish($topic, $message): static
    {
        $this->client::publish($topic, $message);
        return $this;
    }

    public function subscribe($topic, callable $callback): void
    {
        try {
            $mqtt = $this->client::connection();
            //心跳检测
            \Swow\Coroutine::run(static function () use($mqtt, $topic, $callback): void {
                $mqtt->subscribe($topic, function (string $topic, string $message) {
                    file_put_contents(public_path('test\\acde' . date('YmdHis') . '.txt'), $message);
                    $data = json_decode($message);
                }, 1);
                $mqtt->loop(true, true);
            });
            \Swow\Sync\waitAll();
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }

    public function disconnect(): void
    {
        $this->client::disconnect();
    }


}
