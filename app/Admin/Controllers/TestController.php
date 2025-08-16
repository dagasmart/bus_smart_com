<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Yansongda\Pay\Pay;


class TestController extends Controller
{

    public function index()
    {
        dump(asset('css/custom.css'));

        dump(settings()->get('payment'));die;

        Pay::config(config('pay'));


        return Pay::alipay()->h5([
            'out_trade_no' => time(),
            'total_amount' => '0.01',
            'subject' => 'yansongda 测试 - 01',
            'quit_url' => 'https://yansongda.cn',
        ]);

    }

}
