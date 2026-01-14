<?php

declare(strict_types=1);

use Yansongda\Pay\Pay;

return [
    'alipay' => [
        'default' => [
            // 必填-支付宝分配的 app_id
            'app_id' => '2021005182631128',
            // 必填-应用私钥 字符串或路径
            'app_secret_cert' => 'MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDDzg6Izp1kdS+S/dB9C5t84Jey8fqPN78/2SjyHM6l4hoajAa77uzJCyRdiU4VDgDZ6POju5AYHZ+t7VeEWAbQ9aUorVFY5UDT6qUriZYTb3b0NB317KrbEbxndUOAM0d3L1zCWOS5/zuR9O29De9uoJ0wkwqHglF103I/9QGm4cuLEO049bAyuh5kfJ1JdWFIWaM+tf2mdieJP1A0LaITyzoZ+ExzDacYnKKZHtIMkclyA3+OlmGGTxkdbZnSHVDuGefaddhTEd5JYvzK24M0e2Rw1LHyntBfzgkklBpgMP1qy3Vw3yEpkDp0agnlNJ+y/WGDyxomoEvZ/72aN5IJAgMBAAECggEAL+PNAD7wlepneV8kyAC3xeI0mCrA6phq6VXWwuiyzjWvxsBqwTpdpYpZGZuEgnfLU4C7Xld4lb1hGawMFK1m9WKvQ3SoicKAiZRBU5WyJAzGHlJE5ao925jJ6M/wc4GXQBpQaKRPRQKc8kTihLPM1NTpvUCpeZ0xCU1vCx+EiOkQyf0N7DXxyRVFfkTKLIKiau7vqKySmnIn/wIjUQpNr+Y0iVXZEZf532OyW552wZgoPUm3ptMfJVUVGyKCeKpFCGPKnCpPrYEHs5tl/plwhAs30F4MyFVKLIKH4v4tmi2spvcvo5U1NmR2WHFZ/eSQhFm+2HNTwfMx2JWhhFo/RQKBgQD3jiqVKcXEFD7u/TQAxVxWB6s+JKWaGu+wGUbwCIo8Ie/QWte4hmmqxsZG0tCEKpS3WsSrRxk+HkVzq/cnxdJ1MzR8fLfs/pqyk1i9xyb7IcScOZPj4u4/0344yRwctj8lSqRFEuHsPhrTCTUqWbIO9mAcxTEjyofPl99WGR2p3wKBgQDKe/fNQCwrUOq3wXOhXc1j5h6lYCQsLE9HjbTH7nmnfJluAJILs0GAK7y+tdObzfpsEInMXWuyyYmNKesi5IdUXWeJGt9RNlUycNHkAu6BLo5IInYEoNVerHdaFVKkG8QXAmbO1esNB8vkM75w4Ky9Bp64ASZokHcqQB9ha2qRFwKBgQCGUX3rVzH19OI8u+fGb09tYlXYrvunhOv+SYjC3m9atzMugsu/VDbrMVUNwn7e51evsLE7GaWpnbUjUPAWhXBupOzairUlAvQe5nHk7rTI2AacmWUT5eJNgUxgNUZqkbvrWPeOfvNUQlI9pSZSpz5EfguiMKA8Ajz0Nzw3tALzUwKBgQCaGptQFOUI2n6o94xfZZqpyzvLtU4SaG62EH1kJHVmKQhElh6Q1Q6m06LEqnGwhKVwlW2qofcTjRso2pxgY/kzFht0V4Vas7VHvGGh3TFUE/CpqcCUaSu68But7ciFqbQlpuhDxr8rnaFpvo/ULMqK2nz1obpvnnNzLnYzmKL0ZQKBgE8I6aCONi8VueB9SZ9js3dHuGAPR+yz5Gv/K3ldOe3Pi4GF9+FXZnzvSrOeFIAcoUxVR1a3FMnVXNmPOrBAcMj+aKKFoTcFLuPEbxuCtBkYlNEvfHAXkONxDckmHCc1DQVZY3UBD9Z6xTG9w1jql4LYL92qVhk5z/DOCw4yhgge',
            // 必填-应用公钥证书 路径
            'app_public_cert_path' => base_path('data/cert/alipay/plat/2021005182631128_appCertPublicKey.crt'),
            // 必填-支付宝公钥证书 路径
            'alipay_public_cert_path' => base_path('data/cert/alipay/plat/2021005182631128_alipayCertPublicKey_RSA2.crt'),
            // 必填-支付宝根证书 路径
            'alipay_root_cert_path' => base_path('data/cert/alipay/plat/2021005182631128_alipayRootCert.crt'),
            'return_url' => env('APP_URL', '') . '/payment/return',
            'notify_url' => env('APP_URL', '') . '/payment/notify',
            // 选填-服务商模式下的服务商 id，当 mode 为 Pay::MODE_SERVICE 时使用该参数
            'service_provider_id' => '',
            // 选填-默认为正常模式。可选为： MODE_NORMAL, MODE_SANDBOX, MODE_SERVICE
            'mode' => Pay::MODE_NORMAL,
        ],
    ],
    'wechat' => [
        'default' => [
            // 必填-商户号，服务商模式下为服务商商户号
            'mch_id' => '1647766518',
            // 选填-v2商户私钥
            'mch_secret_key_v2' => '',
            // 必填-商户秘钥
            'mch_secret_key' => '9af75a4b973d1b09c279a91c10f0c253',
            // 必填-商户私钥 字符串或路径
            'mch_secret_cert' => base_path('/data/cert/wechat/mch/1647766518_apiclient_key.pem'),
            // 必填-商户公钥证书路径
            'mch_public_cert_path' => base_path('/data/cert/wechat/mch/1647766518_apiclient_cert.pem'),
            // 必填
            'notify_url' => 'https://api.eduonline-cn.com/wechat/payment/notify',
            // 选填-公众号 的 app_id
            'mp_app_id' => '',
            // 选填-小程序 的 app_id
            'mini_app_id' => 'wxd754a94bdf7b0632',
            // 选填-app 的 app_id
            'app_id' => '',
            // 选填-服务商模式下，子公众号 的 app_id
            'sub_mp_app_id' => '',
            // 选填-服务商模式下，子 app 的 app_id
            'sub_app_id' => '',
            // 选填-服务商模式下，子小程序 的 app_id
            'sub_mini_app_id' => '',
            // 选填-服务商模式下，子商户id
            'sub_mch_id' => '',
            // 选填-微信公钥证书路径, optional，强烈建议 php-fpm 模式下配置此参数
            'wechat_public_cert_path' => [
                //'18E182757D735784364430081DF3314C81FF59B6' => base_path('/data/cert/wechat/mch/1647766518_pub_key.pem'),
            ],
            // 选填-默认为正常模式。可选为： MODE_NORMAL, MODE_SERVICE
            'mode' => Pay::MODE_NORMAL,
        ],
    ],
    'unipay' => [
        'default' => [
            // 必填-商户号
            'mch_id' => '',
            // 选填-商户密钥：为银联条码支付综合前置平台配置：https://up.95516.com/open/openapi?code=unionpay
            'mch_secret_key' => '979da4cfccbae7923641daa5dd7047c2',
            // 必填-商户公私钥
            'mch_cert_path' => '',
            // 必填-商户公私钥密码
            'mch_cert_password' => '000000',
            // 必填-银联公钥证书路径
            'unipay_public_cert_path' => '',
            // 必填
            'return_url' => '',
            // 必填
            'notify_url' => '',
        ],
    ],
    'douyin' => [
        'default' => [
            // 选填-商户号
            // 抖音开放平台 --> 应用详情 --> 支付信息 --> 产品管理 --> 商户号
            'mch_id' => '',
            // 必填-支付 Token，用于支付回调签名
            // 抖音开放平台 --> 应用详情 --> 支付信息 --> 支付设置 --> Token(令牌)
            'mch_secret_token' => '',
            // 必填-支付 SALT，用于支付签名
            // 抖音开放平台 --> 应用详情 --> 支付信息 --> 支付设置 --> SALT
            'mch_secret_salt' => '',
            // 必填-小程序 app_id
            // 抖音开放平台 --> 应用详情 --> 支付信息 --> 支付设置 --> 小程序appid
            'mini_app_id' => '',
            // 选填-抖音开放平台服务商id
            'thirdparty_id' => '',
            // 选填-抖音支付回调地址
            'notify_url' => '',
        ],
    ],
    'jsb' => [
        'default' => [
            // 服务代码
            'svr_code' => '',
            // 必填-合作商ID
            'partner_id' => '',
            // 必填-公私钥对编号
            'public_key_code' => '00',
            // 必填-商户私钥(加密签名)
            'mch_secret_cert_path' => '',
            // 必填-商户公钥证书路径(提供江苏银行进行验证签名用)
            'mch_public_cert_path' => '',
            // 必填-江苏银行的公钥(用于解密江苏银行返回的数据)
            'jsb_public_cert_path' => '',
            //支付通知地址
            'notify_url'            => '',
            // 选填-默认为正常模式。可选为： MODE_NORMAL:正式环境, MODE_SANDBOX:测试环境
            'mode' => Pay::MODE_NORMAL,
        ]
    ],
    'http' => [ // optional
        'timeout' => 5.0,
        'connect_timeout' => 5.0,
        // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
    ],
    // optional，默认 warning；日志路径为：sys_get_temp_dir().'/logs/yansongda.pay.log'
    'logger' => [
        'enable' => false,
        'file' => null,
        'level' => 'debug',
        'type' => 'single', // optional, 可选 daily.
        'max_file' => 30,
    ],
];
