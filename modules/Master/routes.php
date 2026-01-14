<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::get('/master', fn() => \DagaSmart\BizAdmin\Admin::view(config('master.admin.route.prefix')));

//需登录与鉴权
Route::group([
    'as'         => 'master',
    'domain'     => config('master.admin.route.domain'),
    'prefix'     => config('master.admin.route.prefix'),
    'middleware' => config('master.admin.route.middleware'),
], function (Router $router) {
    $router->resource('dashboard', \Modules\Master\Controllers\HomeController::class);
    $router->resource('system/settings', \Modules\Master\Controllers\SettingController::class);
});

//免登录无限制
Route::group([
    'as'         => 'master',
    'domain'     => config('master.admin.route.domain'),
    'prefix'     => config('master.admin.route.prefix'),
], function (Router $router) {
    $router->get('_iconify_search', [\DagaSmart\BizAdmin\Controllers\IndexController::class, 'iconifySearch']);

});
