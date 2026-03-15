<?php

namespace Modules\Web\Services;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DagaSmart\BizAdmin\Renderers\Page;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use DagaSmart\BizAdmin\Traits\ErrorTrait;
use Illuminate\Database\Eloquent\Builder;
use DagaSmart\BizAdmin\Renderers\TableColumn;

abstract class BaseService
{
    use ErrorTrait;

    protected $tableColumn;

    protected string $modelName;

    protected Request $request;

    protected ?Model $currentModel = null;

    public function __construct()
    {
        $this->request = request();
    }

    public static function make(): static
    {
        return new static;
    }

    public function setModelName($modelName)
    {
        $this->modelName = $modelName;
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return new $this->modelName;
    }

    /**
     * 获取当前操作的数据实例（新增/修改后）
     *
     * @return Model|null
     */
    public function getCurrentModel(): ?Model
    {
        return $this->currentModel;
    }

    /**
     * 设置当前操作的数据实例
     *
     * @param Model|null $model
     * @return $this
     */
    public function setCurrentModel(?Model $model): static
    {
        $this->currentModel = $model;
        return $this;
    }

    public function primaryKey()
    {
        return $this->getModel()->getKeyName();
    }

    public function getTableColumns()
    {
        if (!$this->tableColumn) {
            try {
                // laravel11: sqlite 暂时无法获取字段, 等待 laravel 适配
                $this->tableColumn = Schema::connection($this->getModel()->getConnectionName())
                    ->getColumnListing($this->getModel()->getTable());
            } catch (\Throwable $e) {
                $this->tableColumn = [];
            }
        }

        return $this->tableColumn;
    }

    public function hasColumn($column)
    {
        $columns = $this->getTableColumns();

        if (blank($columns)) return true;

        return in_array($column, $columns);
    }

    public function query()
    {
        return $this->modelName::query();
    }

    /**
     * 详情 获取数据
     *
     * @param $id
     *
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function getDetail($id)
    {
        $query = $this->query();

        $this->addRelations($query, 'detail');

        return $query->find($id);
    }

    /**
     * 编辑 获取数据
     *
     * @param $id
     *
     * @return Model|\Illuminate\Database\Eloquent\Collection|Builder|array|null
     */
    public function getEditData($id)
    {
        $model = $this->getModel();

        $hidden = collect([$model->getCreatedAtColumn(), $model->getUpdatedAtColumn()])
            ->filter(fn($item) => $item !== null)
            ->toArray();

        $query = $this->query();

        $this->addRelations($query, 'edit');

        $data = $query->find($id);

        // 防止数据不存在时报错
        return $data ? $data->makeHidden($hidden) : null;

    }

    /**
     * 列表 获取查询
     *
     * @return Builder
     */
    public function listQuery()
    {
        $query = $this->query();

        // 处理排序
        $this->sortable($query);

        // 自动加载 TableColumn 内的关联关系
        $this->loadRelations($query);

        // 处理查询
        $this->searchable($query);

        // 追加关联关系
        $this->addRelations($query);

        return $query;
    }

    /**
     * 添加关联关系
     *
     * 预留钩子, 方便处理只需要添加 [关联] 的情况
     *
     * @param        $query
     * @param string $scene 场景: list, detail, edit
     *
     * @return void
     */
    public function addRelations($query, string $scene = 'list')
    {

    }

    /**
     * 根据 tableColumn 定义的列, 自动加载关联关系
     *
     * @param $query
     *
     * @return void
     */
    public function loadRelations($query)
    {
        $controller = Route::getCurrentRoute()->getController();

        // 当前列表结构
        $schema = method_exists($controller, 'list') ? $controller->list() : '';

        if (!$schema instanceof Page) return;

        // 字段
        $columns = $schema->toArray()['body']->amisSchema['columns'] ?? [];

        $relations = [];
        foreach ($columns as $column) {
            // 排除非表格字段
            if (!$column instanceof TableColumn) continue;
            // 拆分字段名
            $field = $column->amisSchema['name'] ?? null;
            if (!$field) continue;
            // 是否是多层级
            if (str_contains($field, '.')) {
                // 去除字段名
                $list = array_slice(explode('.', $field), 0, -1);
                try {
                    $_class = $this->modelName;
                    foreach ($list as $item) {
                        $_class = app($_class)->{$item}()->getModel()::class;
                    }
                } catch (\Throwable $e) {
                    continue;
                }
                $relations[] = implode('.', $list);
            }
        }

        // 加载关联关系
        $query->with(array_unique($relations));
    }

    /**
     * 排序
     *
     * @param $query
     *
     * @return void
     */
    public function sortable($query)
    {
        if (request()->orderBy && request()->orderDir) {
            $query->orderBy(request()->orderBy, request()->orderDir ?? 'asc');
        } else {
            $query->orderByDesc($this->sortColumn());
        }
    }

    /**
     * 搜索
     *
     * @param $query
     *
     * @return void
     */
    public function searchable($query)
    {
        collect(array_keys(request()->query()))
            ->intersect($this->getTableColumns())
            ->map(function ($field) use ($query) {
                $query->when(filled(request($field)), function ($query) use ($field) {
                    if (mb_strpos(request($field), ',')) {
                        $explode = explode(',', request($field));
                        if ($explode && count($explode) == 2) {
                            //判断时间戳格式
                            list($startime, $endtime) = $explode;
                            if (isValidDate($startime) && isValidDate($endtime)) {
                                $query->whereBetween($field, [$startime, $endtime]);
                            } else if (isTimestamp($startime) && isTimestamp($endtime)) {
                                $startime = date('Y-m-d H:i:s', $startime);
                                $endtime = date('Y-m-d H:i:s', $endtime);
                                $query->whereBetween($field, [$startime, $endtime]);
                            } else {
                                $query->whereIn($field, $explode);
                            }
                        } else {
                            $query->whereIn($field, $explode);
                        }
                    } else {
                        //获取字段类型
                        $columnType = Schema::connection($this->getModel()->getConnectionName())
                            ->getColumnType($this->getModel()->getTable(), $field);
                        //只保留字母
                        $columnType = preg_replace('/[^A-Za-z]/', '', $columnType);
                        //判断类型
                        if(in_array($columnType, ['bool','boolean','int','integer'])) {
                            $query->where($field, request($field));
                        } else {
                            $query->where($field, 'like', '%' . request($field) . '%');
                        }
                    }
                });
            });
    }

    /**
     * 列表 排序字段
     *
     * @return string
     */
    public function sortColumn()
    {
        $updatedAtColumn = $this->getModel()->getUpdatedAtColumn();

        if ($this->getModel()->timestamps && $this->hasColumn($updatedAtColumn)) {
            return $updatedAtColumn;
        }

        if ($this->hasColumn($this->getModel()->getKeyName())) {
            return $this->getModel()->getKeyName();
        }

        return Arr::first($this->getTableColumns());
    }

    /**
     * 格式化列表数据
     *
     * @param array $rows 一次分页的数据
     *
     * @return array
     */
    public function formatRows(array $rows)
    {
        return $rows;
    }

    /**
     * 列表 获取数据
     *
     * @return array
     */
    public function list()
    {
        $query = $this->listQuery();

        $list  = $query->paginate(request()->input('perPage', 20));
        $items = $this->formatRows($list->items());
        $total = $list->total();

        return ['items' => $items, 'total' => $total];
    }

    /**
     * 修改
     *
     * @param $primaryKey
     * @param $data
     *
     * @return bool
     */
    public function update($primaryKey, $data)
    {
        DB::beginTransaction();
        try {
            $this->saving($data, $primaryKey);

            $model = $this->query()->whereKey($primaryKey)->first();

            foreach ($data as $k => $v) {
                if (!$this->hasColumn($k)) {
                    continue;
                }

                $model->setAttribute($k, $v);
            }

            $result = $model->save();

            // 无论数据是否变更,都赋值当前模型实例
            $this->currentModel = $model;

            if ($result) {
                $this->saved($model, true);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            admin_abort($e->getMessage());
        }

        return $result;
    }

    /**
     * 新增
     *
     * @param $data
     *
     * @return bool
     */
    public function store($data)
    {
        DB::beginTransaction();
        try {
            $this->saving($data);

            $model = $this->getModel();

            foreach ($data as $k => $v) {
                if (!$this->hasColumn($k)) {
                    continue;
                }
                $model->setAttribute($k, $v);
            }

            $result = $model->save();

            // 无论是否保存成功,都赋值当前模型实例
            $this->currentModel = $model;

            if ($result) {
                $this->saved($model);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            admin_abort($e->getMessage());
        }

        return $result;
    }

    /**
     * deleting 钩子 (执行于删除前)
     * @return void
     */
    public function deleting(string $ids)
    {
        return $ids;
    }

    /**
     * 删除
     *
     * @param string $ids
     *
     * @return mixed
     */
    public function delete(string $ids)
    {
        DB::beginTransaction();
        try {

            $ids = $this->deleting($ids);

            $result = $this->query()->whereIn($this->primaryKey(), explode(',', $ids))->delete();

            if ($result) {
                $this->deleted($ids);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            admin_abort($e->getMessage());
        }

        return $result;
    }

    /**
     * 快速编辑
     *
     * @param $data
     *
     * @return true
     */
    public function quickEdit($data)
    {
        $rowsDiff = data_get($data, 'rowsDiff', []);

        DB::beginTransaction();
        try {
            foreach ($rowsDiff as $item) {
                $this->update(Arr::pull($item, $this->primaryKey()), $item);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            admin_abort($e->getMessage());
        }

        return true;
    }

    /**
     * 快速编辑单条
     *
     * @param $data
     *
     * @return bool
     */
    public function quickEditItem($data)
    {
        return $this->update(Arr::pull($data, $this->primaryKey()), $data);
    }

    /**
     * saving 钩子 (执行于新增/修改前)
     *
     * 可以通过判断 $primaryKey 是否存在来判断是新增还是修改
     *
     * @param $data
     * @param $primaryKey
     *
     * @return void
     */
    public function saving(&$data, $primaryKey = '')
    {
        /**
         * 获取 表名
         */
        $table = $this->getModel()->getTable();
        /**
         * 判断
         * 表名、表和表字段同时存在时追加参数字段
         */
        if ($table && Schema::hasTable($table)) {
            /**
             * 判断
             * 表名、表和表字段同时存在时，追加模块module
             */
            if (Schema::hasColumn($table, 'module')) {
                $data['module'] = admin_current_module();
            }
            /**
             * 判断
             * 表名、表和表字段同时存在时，追加商户mer_id
             */
            if (Schema::hasColumn($table, 'mer_id')) {
                $data['mer_id'] = admin_mer_id();
            }
        }

    }

    /**
     * saved 钩子 (执行于新增/修改后)
     *
     * 可以通过 $isEdit 来判断是新增还是修改
     *
     * @param $model
     * @param $isEdit
     *
     * @return void
     */
    public function saved($model, $isEdit = false)
    {

    }

    /**
     * deleted 钩子 (执行于删除后)
     *
     * @param $ids
     *
     * @return void
     */
    public function deleted($ids)
    {


    }

    /**
     * 获取商户
     * @return mixed
     */
    public function getMerchantAll()
    {
        return \DagaSmart\BizAdmin\Models\SystemMerchant::query()
            ->orderBy('id')
            ->get(['id as value', 'mer_name as label'])
            ->toArray();
    }

    public function operOption($code = null)
    {
        return $this->getModel()->operOption($code);
    }

    public function dataOption($code = null)
    {
        return $this->getModel()->dataOption($code);
    }

    /**
     * 授权角色列表
     * @return mixed
     */
    public function roleOption($defer = false)
    {
        return AdminRoleService::make()->roleOption($defer);
    }

    /**
     * 授权角色用户列表
     * @return mixed
     */
    public function roleUserOption($defer = false)
    {
        return AdminRoleUserService::make()->roleUserOption($defer);
//        $data = [];
//        $roles = $this->roleOption($defer);
//        if ($roles) {
//            foreach ($roles as $key => $role) {
//                $data[$key]['ref'] = $role['id'];
//                $data[$key]['children'] = AdminRoleUserService::make()->userOption($defer);
//            }
//        }
//        return $data;
    }

    /**
     * 是否状态类型
     * @return mixed
     */
    public function switchOption()
    {
        return $this->getModel()->switchOption();
    }

    /**
     * 授权使用类型
     * @return mixed
     */
    public function authOption()
    {
        return $this->getModel()->authOption();
    }

    /**
     * 支付状态
     * @return mixed
     */
    public function payOption()
    {
        return $this->getModel()->payOption();
    }

    /**
     * 状态类型
     * @return mixed
     */
    public function stateOption()
    {
        return $this->getModel()->stateOption();
    }

    /**
     * 审核状态类型
     * @return mixed
     */
    public function auditOption()
    {
        return $this->getModel()->auditOption();
    }

    /**
     * 状态映射
     * @return mixed
     */
    public function auditMapping()
    {
        return $this->getModel()->auditMapping();
    }

    /**
     * 状态映射
     * @return mixed
     */
    public function statusMapping()
    {
        return $this->getModel()->statusMapping();
    }

    /**
     * 项目子模块
     * @return mixed
     */
    public function moduleOption()
    {
        return $this->getModel()->moduleOption();
    }


    /**
     * 保存授权模块,逗号分隔‘,’
     * @return bool
     */
    public function saveModules($id, $modules = null, $init = null)
    {
        admin_abort_if(!$id, '{id}参数不能为空');
        return $this->getModel()->saveModules($id, $modules, $init);
    }

    /**
     * 获取组
     * @return  mixed
     */
    public function getGroups()
    {
        return $this->getModel()->getGroups();
    }

}
