<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use DagaSmart\BizAdmin\Models\SystemSoftOrder;
use Exception;
use Fiber;
use Illuminate\Support\Facades\DB;
use Yansongda\Pay\Pay;


class TestController extends Controller
{

    public function index()
    {
        $coroutine = new Fiber(function () {
            $res = admin_sql_select("SELECT * FROM trade_order_log");
            Fiber::suspend($res);

            try {
                $received = Fiber::suspend('Give me something.');
                Fiber::suspend(sprintf('You gave me a value of "%s": ', $received));
            } catch (\Throwable $e) {
                Fiber::suspend(sprintf('You gave me this exception: "%s".', $e->getMessage()));
            }
        } );

        $hello = $coroutine->start();
        dump($hello); // Hello from the fiber.

        $message = $coroutine->resume('Hello from the code');
        dump($message); // Give me something.

        $result = $coroutine->throw( new Exception( 'Exception from the code' ) );
        dump($result);

        die;






        $stream = \Ripple\File\File::getContents(admin_chart_path('theme/chalk.json'));
        dump(json_decode($stream, true));
        die;

        try {
            $fiber = new Fiber(function (): void {
                $expire = SystemSoftOrder::EXPIRE;
                SystemSoftOrder::query()
                    ->where('service_endate', '>', 0)
                    ->where('service_endate', '<', DB::raw("EXTRACT(EPOCH FROM CURRENT_DATE + $expire)"))
                    ->update(['order_no' => DB::raw("CONCAT('SOFT', TO_CHAR(updated_at,'yyyymmddhh24miss'), id)")]);
            });
            $fiber->start();
        } catch (\Throwable $e) {
        }

        echo 121212122;

        die;

        // 使用 Fibers 的示例
        $fiber =new Fiber(function(){
          $result = Fiber::suspend($http->asyncRequest('https://api.example.com'));
          echo $result;
        });
        $fiber->start();

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
