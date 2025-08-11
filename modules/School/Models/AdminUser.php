<?php

namespace Modules\School\Models;

class AdminUser extends \DagaSmart\BizAdmin\Models\AdminUser
{
    protected $table = 'school_admin_users';

    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(AdminRole::class, 'school_admin_role_users', 'user_id', 'role_id')->withTimestamps();
    }
}
