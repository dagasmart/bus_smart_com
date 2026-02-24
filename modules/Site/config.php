<?php

return [
    // 应用名称
    'name'           => 'master Admin™',

    // 应用 logo
    'logo'           => '/admin-assets/logo.svg',

    // 默认头像
    'default_avatar' => '/admin-assets/default-avatar.svg',

    // 默认占位图片
    'default_image' => '/admin-assets/default-image.svg',

    // 引导文件
    'bootstrap' => base_path('\modules/Master/bootstrap.php'),

    //外部访问
    'link' => env('APP_LINK', env('APP_URL')),

    // 应用路由
    'route' => [
        'prefix'               => 'master-api',
        'domain'               => null,
        'namespace'            => 'Modules\Master\Controllers',
        'middleware'           => ['admin'],
        // 不包含额外路由, 配置后, 不会追加新增/详情/编辑页面路由
        'without_extra_routes' => [
            '/dashboard',
        ],
    ],

    'auth' => [
        // 是否开启验证码
        'login_captcha' => env('ADMIN_LOGIN_CAPTCHA', true),
        // 是否开启认证
        'enable'        => true,
        // 是否开启鉴权
        'permission'    => true,
        'guard'         => 'master',
        'guards' => [
            'master' => [
                'driver'   => 'sanctum',
                'provider' => 'master',
            ],
        ],
        'providers' => [
            'master' => [
                'driver' => 'eloquent',
                'model'  => \Modules\Master\Models\AdminUser::class,
            ],
        ],
        'except'        => [

        ],
    ],

    'upload' => [
        'disk'      => env('ADMIN_UPLOAD_DISK', 'public'),
        // 文件上传目录
        'directory' => [
            'image' => env('ADMIN_UPLOAD_IMAGE_DIRECTORY', 'images'),
            'file'  => env('ADMIN_UPLOAD_FILE_DIRECTORY', 'files'),
            'rich'  => env('ADMIN_UPLOAD_RICH_DIRECTORY', 'rich'),
            'cert'  => env('ADMIN_UPLOAD_CERT_DIRECTORY', 'cert'),
        ],
    ],

    'https'                                => env('ADMIN_HTTPS', false),

    // 是否显示 [开发者工具]
    'show_development_tools'               => env('ADMIN_SHOW_DEVELOPMENT_TOOLS', true),

    // 是否显示 [权限] 功能中的自动生成按钮
    'show_auto_generate_permission_button' => env('ADMIN_SHOW_AUTO_GENERATE_PERMISSION_BUTTON', true),

    'layout' => [
        // 浏览器标题, 功能名称使用 %title% 代替
        'title'              => '%title% | master Admin™',
        'header'             => [
            // 是否显示 [刷新] 按钮
            'refresh'      => true,
            // 是否显示 [暗色模式] 按钮
            'dark'         => true,
            // 是否显示 [全屏] 按钮
            'full_screen'  => true,
            // 是否显示 [多语言] 按钮
            'locale_toggle' => true,
            // 是否显示 [主题配置] 按钮
            'theme_config' => true,
        ],
        'locale_options'     => [
            'en'    => 'English',
            'zh_CN' => '简体中文',
        ],
        /*
         * keep_alive 页面缓存黑名单
         *
         * eg:
         * 列表: /user
         * 详情: /user/:id
         * 编辑: /user/:id/edit
         * 新增: /user/create
         */
        'keep_alive_exclude' => [],
        // 底部信息
        'footer'             => '<a href="https://github.com/dagasmart/bizadmin" target="_blank">master Admin</a>',
    ],

    'models' => [
        'admin_user'           => \Modules\Master\Models\AdminUser::class,
        'admin_role'           => \Modules\Master\Models\AdminRole::class,
        'admin_menu'           => \Modules\Master\Models\AdminMenu::class,
        'admin_permission'     => \Modules\Master\Models\AdminPermission::class,
        'admin_role_user'      => \Modules\Master\Models\AdminRoleUser::class,
    ],
];
