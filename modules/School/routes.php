<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::get('/school', fn() => \DagaSmart\BizAdmin\Admin::view(config('school.admin.route.prefix')));

//需登录与鉴权
Route::group([
    'as'         => 'school',
    'domain'     => config('school.admin.route.domain'),
    'prefix'     => config('school.admin.route.prefix'),
    'middleware' => config('school.admin.route.middleware'),
], function (Router $router) {
    $router->resource('dashboard', \Modules\School\Controllers\HomeController::class);
    $router->resource('system/settings', \Modules\School\Controllers\SettingController::class);
});

//免登录无限制
Route::group([
    'as'         => 'school',
    'domain'     => config('school.admin.route.domain'),
    'prefix'     => config('school.admin.route.prefix'),
], function (Router $router) {
    $router->get('_iconify_search', [\DagaSmart\BizAdmin\Controllers\IndexController::class, 'iconifySearch']);

});
