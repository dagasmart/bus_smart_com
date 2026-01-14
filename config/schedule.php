<?php

return [
    'table' => 'task_schedule',
    'group' => 'task_schedule_group',
    'log' => 'task_schedule_log',

    'enum' => '',

    'model' => \DagaSmart\TaskSchedule\Models\TaskSchedule::class,

    'output' => [
        'path' => storage_path('logs'),
    ],
];
