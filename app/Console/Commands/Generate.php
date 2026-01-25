<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Generate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'school:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): false|int
    {
        if (!is_dir(public_path('test'))) {
            @mkdir(public_path('test'));
        }
        return file_put_contents(public_path('test\\'.date('YmdH').'.txt'), time());
    }
}
