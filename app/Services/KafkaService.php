<?php

namespace App\Services;

use RdKafka\Conf;
use RdKafka\Producer;
use RdKafka\Consumer;
use RdKafka\KafkaConsumer;
use RdKafka\TopicConf;

class KafkaService
{
    protected $brokers;
    protected $groupId;

    public function __construct()
    {
        $this->brokers = config('kafka.brokers');
        $this->groupId = config('kafka.group_id');
    }

    public function createProducer()
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', $this->brokers);

        // 设置生产者配置
        foreach (config('kafka.producer.options', []) as $key => $value) {
            $conf->set($key, $value);
        }

        $producer = new Producer($conf);
        $producer->addBrokers($this->brokers);

        return $producer;
    }

    public function createConsumer($topics)
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', $this->brokers);
        $conf->set('group.id', $this->groupId);

        // 设置消费者配置
        foreach (config('kafka.consumer.options', []) as $key => $value) {
            $conf->set($key, $value);
        }

        $consumer = new KafkaConsumer($conf);
        $consumer->subscribe($topics);

        return $consumer;
    }

    public function produceMessage($topic, $message, $key = null)
    {
        $producer = $this->createProducer();
        $kafkaTopic = $producer->newTopic($topic);

        $payload = is_array($message) ? json_encode($message) : $message;

        $kafkaTopic->produce(RD_KAFKA_PARTITION_UA, 0, $payload, $key);
        $producer->poll(0);

        // 等待消息发送完成
        for ($flushRetries = 0; $flushRetries < 10; $flushRetries++) {
            $result = $producer->flush(1000);
            if (RD_KAFKA_RESP_ERR_NO_ERROR === $result) {
                break;
            }
        }

        return true;
    }

    public function consumeMessages($topics, $callback, $timeoutMs = 120000)
    {
        $consumer = $this->createConsumer($topics);

        while (true) {
            $message = $consumer->consume($timeoutMs);

            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    // 处理消息
                    $result = call_user_func($callback, $message);

                    // 手动提交偏移量
                    if ($result !== false) {
                        $consumer->commit($message);
                    }
                    break;
                case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                    echo "已到达分区末尾\n";
                    break;
                case RD_KAFKA_RESP_ERR__TIMED_OUT:
                    echo "超时\n";
                    break;
                default:
                    throw new \Exception($message->errstr(), $message->err);
            }
        }
    }

}
