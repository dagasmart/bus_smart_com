<?php

namespace Modules\School;

use Illuminate\Support\ServiceProvider;

class SchoolServiceProvider extends ServiceProvider
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
