<?php

namespace App\Console\Commands;

use Exception;
use Fiber;
use Illuminate\Console\Command;
use Swow\Coroutine;
use Symfony\Component\Console\Command\Command as CommandAlias;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Command description";

    /**
     * Execute the console command.
     */
    public function handle()
    {
//        $name = $this->argument('name');
//        $description = $this->description;
//        $this->comment("Hello, {$description}!");
//        $this->comment("Hello, {$name}!");
//        return CommandAlias::SUCCESS;

//        $echo = "Processing job in coroutine...";
//        file_put_contents(public_path(time() . '.test'), microtime(true) . $echo);
//        echo $echo;
        try {
            $fiber = new Fiber(function (): void {
                $echo = "Processing job in coroutine..." . time();
                if (!is_dir(public_path('test'))) {
                    @mkdir(public_path('test'));
                }
                file_put_contents(public_path('test\\'.time().'.txt'), $echo);
            });
            $fiber->start();
        } catch (Exception) {

        }

    }
}

