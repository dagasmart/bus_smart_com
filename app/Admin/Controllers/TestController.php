<?php

namespace App\Admin\Controllers;

use DagaSmart\BizAdmin\Admin;
use DagaSmart\BizAdmin\Models\AdminUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;

class TestController extends Controller
{
    public function index()
    {

        admin_transaction(function () {
            $res = AdminUser::get()->toArray();
            dump($res);
        });
    }
}
