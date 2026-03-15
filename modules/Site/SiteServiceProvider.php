<?php

namespace Modules\Site;

use Illuminate\Support\ServiceProvider;

class SiteServiceProvider extends ServiceProvider
{
    public function register()
    {
        // ...
    }

    public function boot()
    {
        $this->loadMigrationsFrom(database_path('migrations'));
    }
}
