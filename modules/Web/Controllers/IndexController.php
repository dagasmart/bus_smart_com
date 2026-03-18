<?php

namespace Modules\Web\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexController extends BaseController
{
    public function index(): JsonResponse|JsonResource
    {
        // 通过页面标识获取页面结构
        $schema = admin_pages('home');

        // 返回页面数据
        return $this->response()->success($schema);
    }

}
