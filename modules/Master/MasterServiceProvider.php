<?php

namespace Modules\Master;

use Illuminate\Support\ServiceProvider;

class MasterServiceProvider extends ServiceProvider
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
