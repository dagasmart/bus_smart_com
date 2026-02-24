<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

//页面模板
Route::group([
    'as'         => 'site',
    'domain'     => config('site.admin.route.domain'),
    'prefix'     => '@',
], function (Router $router) {
    $router->get('web/index', [\Modules\Site\Controllers\IndexController::class, 'index']);
});

