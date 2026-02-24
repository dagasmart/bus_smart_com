<?php

namespace Modules\Site\Models;

class AdminUser extends \DagaSmart\BizAdmin\Models\AdminUser
{
    protected $table = 'master_admin_users';

    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(AdminRole::class, 'master_admin_role_users', 'user_id', 'role_id')->withTimestamps();
    }
}
