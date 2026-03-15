<?php

namespace Modules\Web\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AdminPermission extends \DagaSmart\BizAdmin\Models\AdminPermission
{
    protected $table = 'site_admin_permissions';

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(AdminMenu::class, 'site_admin_permission_menu', 'permission_id', 'menu_id')
            ->withTimestamps();
    }
}
