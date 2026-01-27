<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;

class MqttService
{
    protected MqttClient $client;

    public function __construct()
    {
        $this->client = new MqttClient('tcp://1.15.51.149','21883','mqttx_05e244a3'); // 替换为你的 MQTT 服务器地址和端口
    }

    public function connect(): void
    {
        $this->client->connect();
    }

    public function subscribe($topic, $callback)
    {
        $this->client->subscribe($topic, function ($message) use ($callback) {
            $callback($message);
        });
    }

    public function publish($topic, $message)
    {
        $this->client->publish($topic, $message);
    }

    public function disconnect()
    {
        $this->client->disconnect();
    }
    public function loop(){
        $this->client->loop();
    }
}
