<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Tpetry\PostgresqlEnhanced\Support\Facades\Schema;

class SystemTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:system-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): ?bool
    {
        $table = 'vm_school_grade_classes_student_materialized';

        if (!Schema::materializedViewExists($table)) {
            Schema::createMaterializedView($table,
                'SELECT
                a.school_id,b.school_name,a.grade_id,c.grade_name,a.classes_id,d.classes_name,a.student_id,e.student_name,e.id_card,e.student_no
                FROM school.biz_school_grade_classes_student a
                INNER JOIN school.biz_school b ON a.school_id=b.id
                INNER JOIN school.biz_grade c ON a.grade_id=c.id
                INNER JOIN school.biz_classes d ON a.classes_id=d.id
                INNER JOIN school.biz_student e ON a.student_id=e.id',
                withData: false);
        }

        Schema::refreshMaterializedView($table);

        return true;
    }
}
