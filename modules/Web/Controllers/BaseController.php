<?php

namespace Modules\Web\Controllers;

use DagaSmart\BizAdmin\Traits;
use Illuminate\Routing\Controller;
use Modules\Web\Base;
use Modules\Web\Services\BaseService;

abstract class BaseController extends Controller
{
    use Traits\ExportTrait;
    use Traits\UploadTrait;
    use Traits\ElementTrait;
    use Traits\QueryPathTrait;
    use Traits\CheckActionTrait;

    protected BaseService $service;

    /** @var string $queryPath 路径 */
    protected string $queryPath;

    /** @var string|mixed $adminPrefix 路由前缀 */
    protected string $adminPrefix;

    public function __construct()
    {
        if (property_exists($this, 'serviceName')) {
            $this->service = $this->serviceName::make();
        }
        $this->adminPrefix = Base::config('admin.route.prefix');
        $this->queryPath = $this->queryPath ?? str_replace($this->adminPrefix . '/', '', request()->path());
    }


}
