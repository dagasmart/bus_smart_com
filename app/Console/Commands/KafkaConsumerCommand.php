<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\KafkaService;

class KafkaConsumerCommand extends Command
{
    protected $signature = 'kafka:consume {topic?}';
    protected $description = '从Kafka消费消息';

    public function handle(KafkaService $kafkaService)
    {
        $topic = $this->argument('topic') ?? config('kafka.topics.default');
        $this->info("开始监听主题: {$topic}");

        try {
            $kafkaService->consumeMessages([$topic], function ($message) {
                $this->info("收到消息: " . $message->payload);
                $this->info("主题: " . $message->topic_name);
                $this->info("分区: " . $message->partition);
                $this->info("偏移量: " . $message->offset);
                $this->info("---");

                // 在这里处理业务逻辑
                // 返回false可以阻止自动提交偏移量
                return true;
            });
        } catch (\Exception $e) {
            $this->error("消费消息失败: " . $e->getMessage());
        }
    }
}
