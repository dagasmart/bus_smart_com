<?php
declare(strict_types=1);

use Swow\Socket;
use Swow\Utils\Handler;

return [
    'http'       => [
        'enable'     => true,
        'host'       => '0.0.0.0',
        'port'       => 8089,
        'options'    => [],
        //'flags'      => Socket::BIND_FLAG_NONE,
    ],
    'servers' => [
        'default' => [
            'type' => 'http', // 或者 'tcp' 等类型
            'host' => '0.0.0.0',
            'port' => 9501,
            'settings' => [
                'enable_coroutine' => true, // 启用协程支持
                'worker_num' => 4, // 协程工作数量
                'max_coroutine' => 10000, // 最大协程数
            ],
        ],
    ],
    'websocket'  => [
        'enable'        => false,
        'handler'       => Handler::class,
        'ping_interval' => 25,
        'ping_timeout'  => 60,
        'room'          => [
            'type'  => 'redis',
            'redis' => [
                'host'          => '127.0.0.1',
                'port'          => 6379,
                'max_active'    => 3,
                'max_wait_time' => 5,
            ],
        ],
        'listen'        => [],
        'subscribe'     => [],
    ],
    //连接池
    'pool'       => [
        'db'    => [
            'enable'        => true,
            'max_active'    => 3,
            'max_wait_time' => 5,
        ],
        'cache' => [
            'enable'        => true,
            'max_active'    => 3,
            'max_wait_time' => 5,
        ],
        //自定义连接池
    ],
    'ipc'        => [
        // swow是单进程，默认是不需要ipc的
        'enable' => false,
        'type'  => 'redis',
        'redis' => [
            'host'          => '127.0.0.1',
            'port'          => 6379,
            'max_active'    => 3,
            'max_wait_time' => 5,
        ],
    ],
    // ipc标识, 可选getmypid、gethostname等（pid不能含有.）
    'get_pid_func' => 'getmypid',
    // 每个worker里需要预加载以共用的实例
    'concretes'  => [],
    // 重置器
    'resetters'  => [],
    // 每次请求前需要清空的实例
    'instances'  => [],
    // 每次请求前需要重新执行的服务
    'services'   => [],
];
