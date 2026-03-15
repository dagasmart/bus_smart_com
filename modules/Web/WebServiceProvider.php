<?php

namespace Modules\Web;

use Illuminate\Support\ServiceProvider;

class WebServiceProvider extends ServiceProvider
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
