<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::get('/admin', fn() => \DagaSmart\BizAdmin\Admin::view());

//需登录与鉴权
Route::group([
    'domain'     => config('admin.route.domain'),
    'prefix'     => config('admin.route.prefix'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->resource('dashboard', \App\Admin\Controllers\HomeController::class);
    $router->resource('system/settings', \App\Admin\Controllers\SettingController::class);
});

//免登录无限制
Route::group([
    'domain'     => config('admin.route.domain'),
    'prefix'     => config('admin.route.prefix'),
], function (Router $router) {
    $router->get('_iconify_search', [\DagaSmart\BizAdmin\Controllers\IndexController::class, 'iconifySearch']);

    $router->get('test/index', [\App\Admin\Controllers\TestController::class, 'index']);

    $router->get('test/photoBatch', [\App\Admin\Controllers\TestController::class, 'photoBatch']);
    $router->get('test/flushBatch', [\App\Admin\Controllers\TestController::class, 'flushBatch']);
    $router->get('test/batch', [\App\Admin\Controllers\TestController::class, 'batch']);
    $router->get('test/demo', [\App\Admin\Controllers\TestController::class, 'demo']);

    //门禁指令
    $router->get('test/access/face/create', [\App\Admin\Controllers\TestController::class, 'access_face_create']);
    $router->get('test/access/face/delete', [\App\Admin\Controllers\TestController::class, 'access_face_delete']);


});
