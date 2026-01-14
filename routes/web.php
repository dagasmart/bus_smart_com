<?php

use App\Admin\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('kafka');
});

Route::post('/kafka/produce', [Controllers\KafkaController::class, 'produce']);

/**
 * 直接进入指定app模块
 */
Route::domain('erp.smart.com')->get('/', fn() => redirect('/admin'));
Route::domain('www.smart.com')->get('/', fn() => redirect('/api'));

/**
 * 路由报错回调提示
 */
Route::fallback(function () {
    admin_abort('页面不存在（可能原因：1.路由未定义；2.或软件插件未启用）', [], 1);
});
