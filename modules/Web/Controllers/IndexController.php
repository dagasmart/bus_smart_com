<?php

namespace Modules\Web\Controllers;

use DagaSmart\BizAdmin\Renderers\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexController extends BaseController
{
    public function index()
    {
        $page = $this->basePage()->body([
            amis()->Button()->label('234324'),

        ]);
        return $this->response()->success($page);
        //dump(2342);die;
        //return file_get_contents(public_path('admin-assets/index.html'));
    }

}
