<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;

class deviceAccessHeartbeatCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'device:access_heartbeat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '门禁设备心跳检查';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            //心跳检测
            \Swow\Coroutine::run(static function (): void {
                $mqtt = MQTT::connection();
                $mqtt->subscribe('heartbeat/response', function (string $topic, string $message) {
                    file_put_contents(public_path('test\\acde' . date('YmdHis') . '.txt'), $message);
                    $data = json_decode($message);
                    if ($data) {
                        admin_sql_async(
                            "INSERT INTO school.biz_device_activity(device_sn, device_type, device_mac, device_time, device_res, device_version) VALUES(?,?,?,?,?,?) ON CONFLICT (device_sn,device_type)
DO UPDATE SET (device_mac,device_time,device_res,device_version) = (EXCLUDED.device_mac,EXCLUDED.device_time,EXCLUDED.device_res,EXCLUDED.device_version)"
                            ,[$data->sn, 'access', $data->mac, date('Y-m-d H:i:s', $data->time), $message, $data->version]
                        );
                    }
                }, 1);
                $mqtt->loop(true, true);
            });
            \Swow\Sync\waitAll();
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }
}
