<?php

namespace Modules\Web\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class AdminRole extends \DagaSmart\BizAdmin\Models\AdminRole
{
    protected $table = 'site_admin_roles';

    public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(AdminPermission::class, 'site_admin_role_permissions', 'role_id', 'permission_id')
            ->withTimestamps();
    }
}
