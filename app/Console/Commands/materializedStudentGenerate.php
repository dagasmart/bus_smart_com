<?php

namespace App\Console\Commands;

use Fiber;
use Illuminate\Console\Command;
use Tpetry\PostgresqlEnhanced\Support\Facades\Schema;

class materializedStudentGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'school:materialized_student_generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $scheme = 'school'; //库模式
            $name = 'vm_enterprise_grade_classes_student_materialized'; //表视图

            if (!Schema::materializedViewExists($name, $scheme)) {
                \Swow\Coroutine::run(function () use($scheme, $name) {
                    Schema::createMaterializedView($scheme . '.' . $name,
                        'SELECT
                        a.enterprise_id,b.enterprise_name,a.grade_id,c.grade_name,a.classes_id,d.classes_name,a.student_id,e.student_name,e.id_card,e.student_no
                        FROM school.biz_enterprise_grade_classes_student a
                        INNER JOIN school.biz_enterprise b ON a.enterprise_id=b.id
                        INNER JOIN school.biz_grade c ON a.grade_id=c.id
                        INNER JOIN school.biz_classes d ON a.classes_id=d.id
                        INNER JOIN school.biz_student e ON a.student_id=e.id',
                        withData: false);
                    \Swow\Coroutine::run(function () use($scheme, $name) {
                        Schema::refreshMaterializedView($scheme . '.' . $name);
                    });
                });
            } else {
                \Swow\Coroutine::run(function () use($scheme, $name) {
                    Schema::refreshMaterializedView($scheme . '.' . $name);
                });
            }
            \Swow\Sync\waitAll();
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }

//        try {
//            $fiber = new Fiber(function() use($table) {
//                Schema::refreshMaterializedView($table);
//            });
//            $fiber->start();
//            $content = $fiber->getReturn(); // 获取结果
//            dump($content);die; // 输出结果
//        } catch (\Throwable $e) {
//        } // 开始执行 Fiber

    }
}
