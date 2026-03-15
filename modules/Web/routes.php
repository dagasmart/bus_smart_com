<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::get('/web', fn() => \Modules\Web\Base::view(config('site.admin.route.prefix')));

//需登录与鉴权
Route::group([
    'as'         => 'web',
    'domain'     => config('site.admin.route.domain'),
    'prefix'     => config('site.admin.route.prefix'),
    'middleware' => config('site.admin.route.middleware'),
], function (Router $router) {
    $router->resource('dashboard', \Modules\Site\Controllers\HomeController::class);
    $router->resource('system/settings', \Modules\Site\Controllers\SettingController::class);
});

//免登录无限制
Route::group([
    'as'         => 'web',
    'domain'     => config('site.admin.route.domain'),
    'prefix'     => config('site.admin.route.prefix'),
], function (Router $router) {
    $router->get('_iconify_search', [\DagaSmart\BizAdmin\Controllers\IndexController::class, 'iconifySearch']);

});
