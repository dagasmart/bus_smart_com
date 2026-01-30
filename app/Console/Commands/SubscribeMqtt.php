<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MqttService;

class SubscribeMqtt extends Command
{
    protected $signature = 'mqtt:subscribe {topic} {connection?}';
    protected $description = 'Subscribe to MQTT topic';

    public function handle(): void
    {
        $topic = $this->argument('topic') ?? 'laravel/device/#';
        $conn = $this->argument('connection') ?? 'default';

        // 2. 终端输出日志，提示订阅开始
        $this->info("=====================================");
        $this->info("MQTT 订阅已启动 | 时间：" . now()->format('Y-m-d H:i:s'));
        $this->info("订阅主题：{$topic}");
        $this->info("使用连接：{$conn}");
        $this->info("MQTT 服务器：" . config("mqtt-client.connections.{$conn}.host") . ":" . config("mqtt-client.connections.{$conn}.port"));
        $this->info("按 Ctrl+C 停止订阅");
        $this->info("=====================================\n");

        try {
            $mqtt = new MqttService();
            $mqtt->subscribe($topic, function ($topic, $message) {
                //file_put_contents(public_path('test\\abcde' . date('YmdHis') . '.txt'), $message);
                //$this->info("Received message on topic [{$topic}]: {$message}");
                //协程
                \Swow\Coroutine::run(function () use ($topic, $message): void {
                    $this->info("Received message on topic [{$topic}]: {$message}");
                    $data = json_decode($message);
                    // 心跳检测
                    if ($data && $topic == 'heartbeat/response') {
                        $this->heartbeatResponse($data);
                    }

                    // 设备上线
                    if ($data && $topic == 'online/response') {
                        $this->info("Received message on topic [{$topic}]: {$message}");
                    }

                });
                // 在这里处理接收到的消息
            });

        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }
    }

    private function heartbeatResponse($data): void
    {
        if ($data && $data->sn && $data->mac && $data->time && $data->version) {
            admin_sql_async(
                "INSERT INTO school.biz_device_activity(device_sn, device_type, device_mac, device_time, device_res, device_version)
                 VALUES(?,?,?,?,?,?)
                 ON CONFLICT(device_sn,device_type)
                 DO UPDATE SET (device_mac,device_time,device_res,device_version) = (EXCLUDED.device_mac,EXCLUDED.device_time,EXCLUDED.device_res,EXCLUDED.device_version)"
                , [
                    $data->sn,
                    'access',
                    $data->mac,
                    date('Y-m-d H:i:s', $data->time),
                    json_encode($data, JSON_UNESCAPED_UNICODE),
                    $data->version
                ]
            );
        }
    }
}
