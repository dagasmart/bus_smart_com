<?php

namespace Modules\Master\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AdminPermission extends \DagaSmart\BizAdmin\Models\AdminPermission
{
    protected $table = 'master_admin_permissions';

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(AdminMenu::class, 'master_admin_permission_menu', 'permission_id', 'menu_id')
            ->withTimestamps();
    }
}
