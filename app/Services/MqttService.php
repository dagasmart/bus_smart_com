<?php

namespace App\Services;

use PhpMqtt\Client\Facades\MQTT;

class MqttService
{
    protected MQTT $client;

    public function __construct()
    {

        $this->client = new MQTT();
    }

    public function connection(): static
    {
        $this->client::connection();
        return $this;
    }

    public function publish($topic, $message): static
    {
        $this->client::publish($topic, $message);
        //$this->client->disconnect();
        return $this;
    }

    public function subscribe($topic, callable $callback): static
    {
        $this->connection();
        $this->client::subscribe($topic, $callback);
        return $this;
    }

    public function disconnect(): void
    {
        $this->client->disconnect();
    }

    public function loop(): void
    {
        $this->client->connection()->loop(true, true);
    }
}
