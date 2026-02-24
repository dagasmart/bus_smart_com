<?php

namespace Modules\Site\Controllers;

use DagaSmart\BizAdmin\Renderers\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexController extends AdminController
{
    public function index()
    {
        amis()->Panel()->className('h-full clear-card-mb rounded-md')->body([
            amis()->TextControl(),
        ]);
    }

}
