<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::get('/web', fn() => \Modules\Web\Base::view(config('web.admin.route.prefix')));

//需登录与鉴权
Route::group([
    'as'         => 'web',
    'domain'     => config('web.admin.route.domain'),
    'prefix'     => config('web.admin.route.prefix'),
    'middleware' => config('web.admin.route.middleware'),
], function (Router $router) {
    $router->resource('dashboard', \Modules\Web\Controllers\HomeController::class);
    $router->resource('system/settings', \Modules\Web\Controllers\SettingController::class);
});

//免登录无限制
Route::group([
    'as'         => 'web',
    'domain'     => config('web.admin.route.domain'),
    'prefix'     => config('web.admin.route.prefix'),
], function (Router $router) {
    $router->get('_iconify_search', [\DagaSmart\BizAdmin\Controllers\IndexController::class, 'iconifySearch']);

});
