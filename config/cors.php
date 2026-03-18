<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['admin-api/*', 'school-api/*', 'master-api/*', 'site-api/*', 'web-api/*', 'api/*', 'sanctum/csrf-cookie'], // 指定哪些路由需要应用 CORS 配置

    'allowed_methods' => ['*'], // 允许的方法，'*' 表示所有方法都允许

    'allowed_origins' => ['*'], // 允许的源，'*' 表示所有源都允许，生产环境中应指定具体源，例如：['https://example.com']

    'allowed_origins_patterns' => [], // 使用正则表达式匹配源地址

    'allowed_headers' => ['*'], // 允许的头部信息，'*' 表示所有头部都允许

    'exposed_headers' => [], // 暴露的头部信息，例如：['X-My-Custom-Header']

    'max_age' => 0, // 预检请求的结果（即选项请求的响应）可以被缓存多久，单位为秒。0 表示不缓存。

    'supports_credentials' => false, // 是否支持用户凭证，例如 cookies 或 HTTP 认证。默认是 false。如果设置为 true，则 allowed_origins 不应为 '*'。

];
