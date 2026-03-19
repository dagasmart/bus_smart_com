<?php

namespace App\AiAgents;

use LarAgent\Agent;

class WeatherAgent extends Agent
{
    protected $model = 'gpt-oss:20b';

    protected $history = 'in_memory';

    protected $provider = 'ollama';

    protected $tools = [];

    public function instructions()
    {
        return "Define your agent's instructions here.";
    }

    public function prompt($message)
    {
        return $message;
    }
}
