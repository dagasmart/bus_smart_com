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

//设备在线状态同步 10s
Schedule::command('device:online_sync')->everyTenSeconds();


//设备心跳检测 2s
Schedule::command('mqtt:subscribe heartbeat/response')->everyTwoSeconds();
//获取下发命令返回值，MQTT服务端需要订阅
Schedule::command('mqtt:subscribe face/id/response')->everyTwoSeconds();
//推送人脸识别结果
Schedule::command('mqtt:subscribe face/response')->everyTwoSeconds();
//二维码数据
//Schedule::command('mqtt:subscribe qr/response')->everyTwoSeconds();
//设备上线
//Schedule::command('mqtt:subscribe online/response')->everyFiveSeconds();
//推送遗嘱
//Schedule::command('mqtt:subscribe will/sn/response')->everyTwoSeconds();


//Schedule::call(function () {
//    file_put_contents(public_path('test\\') . time().'.txt', time());
//})->everySecond();
