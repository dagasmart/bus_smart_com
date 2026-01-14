<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\KafkaService;

class KafkaProducerCommand extends Command
{
    protected $signature = 'kafka:produce {topic?} {message?}';
    protected $description = '向Kafka发送消息';

    public function handle(KafkaService $kafkaService)
    {
        $topic = $this->argument('topic') ?? config('kafka.topics.default');
        $message = $this->argument('message') ?? $this->ask('请输入要发送的消息');

        try {
            $kafkaService->produceMessage($topic, $message);
            $this->info("消息已发送到主题: {$topic}");
        } catch (\Exception $e) {
            $this->error("发送消息失败: " . $e->getMessage());
        }
    }
}
