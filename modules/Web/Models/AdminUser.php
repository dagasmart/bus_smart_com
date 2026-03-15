<?php

namespace Modules\Web\Models;

class AdminUser extends \DagaSmart\BizAdmin\Models\AdminUser
{
    protected $table = 'site_admin_users';

    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(AdminRole::class, 'site_admin_role_users', 'user_id', 'role_id')->withTimestamps();
    }
}
