<?php

namespace Modules\School\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AdminPermission extends \DagaSmart\BizAdmin\Models\AdminPermission
{
    protected $table = 'school_admin_permissions';

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(AdminMenu::class, 'school_admin_permission_menu', 'permission_id', 'menu_id')
            ->withTimestamps();
    }
}
