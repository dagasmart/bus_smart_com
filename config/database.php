<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for database operations. This is
    | the connection which will be utilized unless another connection
    | is explicitly specified when you execute a query / statement.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Below are all of the database connections defined for your application.
    | An example configuration is provided for each database system which
    | is supported by Laravel. You're free to add / remove connections.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DB_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
            'busy_timeout' => null,
            'journal_mode' => null,
            'synchronous' => null,
        ],

        'mysql' => [
            'driver' => 'mysql',
            //读
            'read' => [
                'host' => explode(',', env('DB_READ_HOST', 'localhost')),
            ],
            //写
            'write' => [
                'host' => explode(',', env('DB_HOST', 'localhost')),
            ],
            'sticky' => true, //读写一致性请求

            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => env('DB_ENGINE', 'InnoDB'),
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
            // 添加连接池配置
            'pool' => [
                'max_connections' => 5, // 最大连接数
                'connection_lifetime' => 600, // 连接生命周期（秒）
                'wait_timeout' => 10, // 等待超时时间（秒）
                'heartbeat' => -1, // 心跳间隔时间（秒），-1 表示不启用
                'max_idle_time' => 60, // 最大空闲时间（秒）
                'capacity' => 10, // 池容量
                'acquire_timeout' => 10000, // 获取连接的超时时间（毫秒）
            ],
        ],

        'mariadb' => [
            'driver' => 'mariadb',
            //读
            'read' => [
                'host' => explode(',', env('DB_READ_HOST', 'localhost')),
            ],
            //写
            'write' => [
                'host' => explode(',', env('DB_HOST', 'localhost')),
            ],
            'sticky' => true, //读写一致性请求

            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => env('DB_ENGINE', 'InnoDB'),
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
            // 添加连接池配置
            'pool' => [
                'max_connections' => 5, // 最大连接数
                'connection_lifetime' => 600, // 连接生命周期（秒）
                'wait_timeout' => 10, // 等待超时时间（秒）
                'heartbeat' => -1, // 心跳间隔时间（秒），-1 表示不启用
                'max_idle_time' => 60, // 最大空闲时间（秒）
                'capacity' => 10, // 池容量
                'acquire_timeout' => 10000, // 获取连接的超时时间（毫秒）
            ],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            //读
            'read' => [
                'host' => explode(',', env('DB_READ_HOST', 'localhost')),
            ],
            //写
            'write' => [
                'host' => explode(',', env('DB_HOST', 'localhost')),
            ],
            //'pool' => [
            //    'min_connections' => 3,
            //    'max_connections' => 20,
            //    'max_lifetime' => 300,
            //],
            'pool' => env('PGSQL_POOL', 20), // 设置连接池最大连接数为10
            'min_connections' => 1, // 最小空闲连接数
            'max_connections' => 1024, // 实际最大可连接数
            'max_idle_time' => 120, // 连接在池中最长可以空闲的时间
            'options' => [
                //'persistent' => true, // 开启持久化连接,会导致资源争用，谨慎使用
                'connect_timeout' => 0, // 设置连接超时时间为5秒
            ],
            'sticky' => true, //读写一致性请求

            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'engine' => env('DB_ENGINE', 'InnoDB'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => env('DB_SCHEMA','public'),
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            // 'encrypt' => env('DB_ENCRYPT', 'yes'),
            // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        ],


        /**
         * bus测试数据库
         *
         * 连接外部pgsql测试库
         */
        'bus' => [
            'driver' => env('DB_CONNECTION_BUS', 'pgsql'),
            //读
            'read' => [
                'host' => explode(',', env('DB_READ_HOST_BUS', 'localhost')),
            ],
            //写
            'write' => [
                'host' => explode(',', env('DB_HOST_BUS', 'localhost')),
            ],
            'pool' => env('PGSQL_POOL', 10), // 设置连接池最大连接数为10
            'min_connections' => 10, // 最小空闲连接数
            'max_connections' => 1024, // 实际最大可连接数
            'max_idle_time' => 10, // 连接在池中最长可以空闲的时间
            'options' => [
                'persistent' => true, // 开启持久化连接,会导致资源争用，谨慎使用
                'connect_timeout' => 5, // 设置连接超时时间为5秒
            ],
            'sticky' => true, //读写一致性请求
            'port' => env('DB_PORT_BUS', '5432'),
            'database' => env('DB_DATABASE_BUS', 'laravel'),
            'username' => env('DB_USERNAME_BUS', 'postgres'),
            'password' => env('DB_PASSWORD_BUS', '123456'),
            'charset' => env('DB_CHARSET_BUS', 'utf8'),
            'engine' => env('DB_ENGINE_BUS', 'InnoDB'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => env('DB_SCHEMA_BUS','public'),
            'sslmode' => 'prefer',
        ],


        /**
         * biz商业数据库
         *
         * 连接外部pgsql商业库
         */
        'biz' => [
            'driver' => env('DB_CONNECTION_BIZ', 'pgsql'),
            //读
            'read' => [
                'host' => explode(',', env('DB_READ_HOST_BIZ', 'localhost')),
            ],
            //写
            'write' => [
                'host' => explode(',', env('DB_HOST_BIZ', 'localhost')),
            ],
            'pool' => env('PGSQL_POOL', 10), // 设置连接池最大连接数为10
            'min_connections' => 10, // 最小空闲连接数
            'max_connections' => 1024, // 实际最大可连接数
            'max_idle_time' => 10, // 连接在池中最长可以空闲的时间
            'options' => [
                'persistent' => true, // 开启持久化连接,会导致资源争用，谨慎使用
                'connect_timeout' => 5, // 设置连接超时时间为5秒
            ],
            'sticky' => true, //读写一致性请求
            'port' => env('DB_PORT_BIZ', '5432'),
            'database' => env('DB_DATABASE_BIZ', 'laravel'),
            'username' => env('DB_USERNAME_BIZ', 'postgres'),
            'password' => env('DB_PASSWORD_BIZ', '123456'),
            'charset' => env('DB_CHARSET_BIZ', 'utf8'),
            'engine' => env('DB_ENGINE_BIZ', 'InnoDB'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => env('DB_SCHEMA_BIZ','public'),
            'sslmode' => 'prefer',
        ],


        /**
         * dev开发数据库
         *
         * 连接外部pgsql开发库
         */
        'dev' => [
            'driver' => env('DB_CONNECTION_DEV', 'pgsql'),
            //读
            'read' => [
                'host' => explode(',', env('DB_READ_HOST_DEV', 'localhost')),
            ],
            //写
            'write' => [
                'host' => explode(',', env('DB_HOST_DEV', 'localhost')),
            ],
            'pool' => env('PGSQL_POOL', 10), // 设置连接池最大连接数为10
            'min_connections' => 10, // 最小空闲连接数
            'max_connections' => 1024, // 实际最大可连接数
            'max_idle_time' => 10, // 连接在池中最长可以空闲的时间
            'options' => [
                'persistent' => true, // 开启持久化连接,会导致资源争用，谨慎使用
                'connect_timeout' => 5, // 设置连接超时时间为5秒
            ],
            'sticky' => true, //读写一致性请求
            'port' => env('DB_PORT_DEV', '5432'),
            'database' => env('DB_DATABASE_DEV', 'laravel'),
            'username' => env('DB_USERNAME_DEV', 'postgres'),
            'password' => env('DB_PASSWORD_DEV', '123456'),
            'charset' => env('DB_CHARSET_DEV', 'utf8'),
            'engine' => env('DB_ENGINE_DEV', 'InnoDB'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => env('DB_SCHEMA_DEV','public'),
            'sslmode' => 'prefer',
        ],


        /**
         * school数据库
         *
         * 连接pgsql
         */
        'school' => [
            'driver' => env('DB_CONNECTION_SCHOOL', 'pgsql'),
            //读
            'read' => [
                'host' => explode(',', env('DB_READ_HOST_SCHOOL', 'localhost')),
            ],
            //写
            'write' => [
                'host' => explode(',', env('DB_HOST_SCHOOL', 'localhost')),
            ],
            'pool' => env('PGSQL_POOL', 10), // 设置连接池最大连接数为10
            'min_connections' => 10, // 最小空闲连接数
            'max_connections' => 1024, // 实际最大可连接数
            'max_idle_time' => 10, // 连接在池中最长可以空闲的时间
            'options' => [
                'persistent' => true, // 开启持久化连接,会导致资源争用，谨慎使用
                'connect_timeout' => 5, // 设置连接超时时间为5秒
            ],
            'sticky' => true, //读写一致性请求
            'port' => env('DB_PORT_SCHOOL', '5432'),
            'database' => env('DB_DATABASE_SCHOOL', 'laravel'),
            'username' => env('DB_USERNAME_SCHOOL', 'postgres'),
            'password' => env('DB_PASSWORD_SCHOOL', '123456'),
            'charset' => env('DB_CHARSET_SCHOOL', 'utf8'),
            'engine' => env('DB_ENGINE_SCHOOL', 'InnoDB'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => env('DB_SCHEMA_SCHOOL','public'),
            'sslmode' => 'prefer',
        ],

        /**
         * mongodb数据库
         *
         * 连接pgsql
         */
        'mongodb' => [
            'driver' => 'mongodb',
            'dsn' => env('MONGODB_URI', 'mongodb://localhost:27017'),
            'database' => env('MONGODB_DATABASE', 'laravel_app'),
        ],



    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run on the database.
    |
    */

    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as Memcached. You may define your connection settings here.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_ENV', 'laravel'), '_').'_database_'),
            'persistent' => env('REDIS_PERSISTENT', false),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
