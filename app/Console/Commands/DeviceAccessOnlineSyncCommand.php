<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeviceAccessOnlineSyncCommand extends Command
{
    protected $signature = 'device:access_online_sync';
    protected $description = '门禁设备状态同步';

    public function handle(): void
    {
        try {
            \Swow\Coroutine::run(static function (): void {
                admin_sql_select("SELECT school.device_online_sync_fun()");
            });
            \Swow\Sync\waitAll();
        } catch (\Exception $e) {
            $this->error("消费消息失败: " . $e->getMessage());
        }
    }
}
