<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

//Artisan::command('inspire', function () {
//    $this->comment(Inspiring::quote());
//})->purpose('Display an inspiring quote');

//Schedule::command('school:generate')->everyMinute();

//测试
//Schedule::command('app:system-test')->cron('0 * * * *');
//设备心跳回调 2s
Schedule::command('device:access_heartbeat')->everyTwoSeconds();
//设备在线状态同步 10s
Schedule::command('device:access_online_sync')->everyTenSeconds();


//Schedule::call(function () {
//    file_put_contents(public_path('test\\') . time().'.txt', time());
//})->everySecond();
