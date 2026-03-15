<?php

namespace Modules\Web\Controllers;

use DagaSmart\BizAdmin\Renderers\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexController extends BaseController
{
    public function index(): JsonResponse|JsonResource
    {
        $page = $this->basePage()->css($this->css())->body([
            amis()->Grid()->columns([
                $this->frameworkInfo()->md(5),
                amis()->Flex()->items([
                    $this->pieChart(),
                    $this->cube(),
                ]),
            ]),
            amis()->Grid()->columns([
                $this->lineChart()->md(8),
                amis()->Flex()->className('h-full')->items([
                    $this->clock(),
                    $this->codeView(),
                ])->direction('column'),
            ]),
        ]);

        return $this->response()->success($page);
    }

}
