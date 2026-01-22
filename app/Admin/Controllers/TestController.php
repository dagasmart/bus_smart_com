<?php
declare(strict_types=1);
namespace App\Admin\Controllers;
@set_time_limit(0);   //设置运行时间
@ini_set('memory_limit', '1G'); //设置运行内存

use Alimranahmed\LaraOCR\Facades\OCR;
use App\Console\Commands\Test;
use App\Http\Controllers\Controller;
use CURLFile;
use DagaSmart\BizAdmin\Models\SystemSoftOrder;
use DagaSmart\School\Models\Student;
use DagaSmart\School\Models\StudentDemo;
use DeepSeek\DeepSeekClient;
use Exception;
use Fiber;
use Generator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\Utils;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;
use JsonMachine\Items;
use Kra8\Snowflake\Snowflake;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Common\Exception\UnsupportedTypeException;
use OpenSpout\Reader\Exception\ReaderNotOpenedException;
use Psr\Http\Message\ResponseInterface;
use Rap2hpoutre\FastExcel\FastExcel;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileObject;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Yansongda\Pay\Pay;
use Swow\Coroutine;
use Swow\Sync\WaitGroup;
use function Illuminate\Support\php_binary;

//use Ripple\WebSocket\Server;


class TestController extends Controller
{

    public function index()
    {

        // 发送消息
        \PhpMqtt\Client\Facades\MQTT::publish('some/topic', 'Hello World!');

        die;


        \Swow\Coroutine::run(static function (): void {
            dump('121');
        });
        die;
        //加密
        $encrypt_str = base64_encrypt('abc123456');
        //解密
        $decrypt_str = base64_decrypt($encrypt_str);
        print_r(['encrypt_str' => $encrypt_str, 'decrypt_str' => $decrypt_str]);

        die;

        // 建立与服务器 RPC 端口的套接字连接
        $client = stream_socket_client('tcp://127.0.0.1:9512', $errorCode, $errorMessage);
        if (false === $client) {
            throw new \Exception('rpc 连接失败: ' . $errorMessage);
        }
// 准备请求数据
        $request = [
            'class'   => 'user',
            'method'  => 'get',
            'args'    => [
                [
                    'uid' => 2023,
                    'username' => 'Tinywan',
                ]
            ]
        ];

        // 发送请求（Text 协议要求数据末尾加换行符）
        fwrite($client, json_encode($request) . "\n");

        // 读取响应
        $result = fgets($client, 10240000);

        // 解析 JSON 响应
        $result = json_decode($result, true);
        var_export($result);

        die;


        dump(admin_extension('dagasmart.access'));die;

        dump(admin_dict()->get('data.filesystem.driver'));die;
//        echo storage_path('app/public/uploads/1000000.png');
        $filePath = 'D:\WorkSpace\Git\GitHub\smart\bus\storage\app\public\uploads\6.jpg';
//        $result = OCR::scan($path)->lang('chi_sim');
//        dump($result);die;


        $users = Items::fromFile('big_8m.json');
        foreach ($users as $id => $user) {
            var_dump($user->name);
        }




        //实例化客户端
        $client = new Client();
        //构造url
        $url = 'http://127.0.0.1:8001/ocr';
        //post请求

        $client = new Client();

// 创建 multipart/form-data 数据流
        $multipart = new MultipartStream([
            [
                'name'     => 'image', // 表单字段名，对应后端接收的文件字段名
                'contents' => fopen($filePath, 'r') // 文件内容，可以是文件路径或文件句柄等
            ],
            [
                'name'     => 'lang', // 表单字段名，对应后端接收的文件字段名
                'contents' => 'ch'
            ]
        ], 'boundary'); // boundary 是分隔符，可以自定义或者使用 MultipartStream 自动生成的一个唯一值

// 创建请求对象，设置请求头和 body 为 multipart 数据流
        $request = new Request('POST', $url, [
            'Content-Type' => 'multipart/form-data; boundary=' . $multipart->getBoundary() // 设置正确的 Content-Type 头部信息
        ], $multipart); // 将 multipart 数据流作为请求体发送

        try {
            // 发送请求并获取响应
            $response = $client->send($request);
            echo $response->getBody(); // 输出响应内容
        } catch (RequestException $e) {
            echo $e->getMessage(); // 捕获异常并输出错误信息
        }





        die;
        $videoFileName = "example_video-file@name.mp4";
        // 过滤掉特殊符号，只保留字母和数字
        $filteredFileName = preg_replace('/[^a-zA-Z0-9\s]/', ' ', strtolower($videoFileName));
        $filteredFileName = ucwords($filteredFileName);
        $s = preg_replace('/\s/', '', $filteredFileName);
        echo $filteredFileName;
        echo $s;

        die;
        identifyByIdCard('123122321354322341');
        $date = date('Ymd',strtotime('last year last month last day'));
        dump($date);die;

        $client = new Client();
        $url = 'http://192.168.1.127/LAPI/V1.0/System/DeviceBasicInfo';

        $response = $client->get($url);

        $body = $response->getBody()->getContents();
        $result = json_decode($body, true);
        dump($result);

        // 设置图片路径
        $imagePath = public_path('storage\\uploads\\1000002.jpg');
        //dump($imagePath);die;
        // 读取图片文件
        $imageData = file_get_contents($imagePath);
        // 将图片转换为Base64格式
        $base64 = base64_encode($imageData);
        //dump($base64);die;

        $data = [
            'Num' => 1,
            'PersonInfoList' => [
                [
                    'PersonID' => 1000002,
                    'LastChange' => time(),
                    'PersonCode' => '',
                    'PersonName' => '饶西奎',
                    'Remarks' => '',
                    'TimeTemplateNum' => 0,
                    'TimeTemplateList' => [
                        [
                            'BeginTime' => 0,
                            'EndTime' => 4294967295,
                            'Index' => 0
                        ]
                    ],
                    'IdentificationNum' => 2,
                    'IdentificationList' => [
                        [
                            'Type' => 1,
                            'Number' => '1000002'
                        ],
                        [
                            'Type' => 99,
                            'Number' => '429006'
                        ]
                    ],
                    'ImageNum' => 1,
                    'ImageList' => [
                        [
                            'FaceID' => 1000002,
                            'Name' => '1000002.jpg',
                            'Size' => strlen($base64),
                            'Data' => $base64
                        ]
                    ],
//                    'FingerprintNum' => 1,
//                    'FingerprintList' => [
//                        [
//                            'FingerprintID' => 123456,
//                            'FeatureSize' => 1080,
//                            'Feature' => 'xQt8ABCFkr……此处省略指纹的转码BASE64数据'
//                        ]
//                    ]
                ]
            ]
        ];


        $client = new Client();
        $url = 'http://192.168.1.127/LAPI/V1.0/PeopleLibraries/1/People';

        $response = $client->post($url, [
            'json' => $data,
        ]);

        $body = $response->getBody()->getContents();
        $result = json_decode($body, true);
        dump($result);
        die;






//        \Tpetry\PostgresqlEnhanced\Support\Facades\Schema::createMaterializedView('vm_school_grade_classes_student_materialized',
//            'SELECT
//                a.school_id,b.school_name,a.grade_id,c.grade_name,a.classes_id,d.classes_name,a.student_id,e.student_name,e.id_card,e.student_no
//                FROM school.biz_school_grade_classes_student a
//                INNER JOIN school.biz_school b ON a.school_id=b.id
//                INNER JOIN school.biz_grade c ON a.grade_id=c.id
//                INNER JOIN school.biz_classes d ON a.classes_id=d.id
//                INNER JOIN school.biz_student e ON a.student_id=e.id',
//            withData: false);
        \Tpetry\PostgresqlEnhanced\Support\Facades\Schema::refreshMaterializedView('vm_school_grade_classes_student_materialized');

        die;

        Broadcast::channel('orders')->push(new NewOrderEvent(123, 'New order placed!'));
        die;

        echo Carbon::now()->startOfMonth()->toDateTimeString();
        echo Carbon::now()->endOfMonth()->toDateTimeString();

        die;
        //dump(\Illuminate\Support\Facades\App::environment());die;
        //$orderData = 2222222222;
        //dispatch(new Test($orderData));

        die;
        var_export(numberToChinese('2335219743226543221.0005'));
        var_export(admin_order_sn());die;

// 加载OpenCV库
        opencv_load_library();

// 创建一个Capture对象，用于调用摄像头
        $capture = opencv_create_capture(0);

// 循环不断地从摄像头中获取图像进行人脸识别
        while (true) {
            // 获取摄像头中的一帧图像
            $frame = opencv_query_frame($capture);

            // 进行人脸识别
            $faceCascade = opencv_load_cascade(opencv_default_xml_cascade());
            $faces = opencv_detect_objects($frame, $faceCascade);

            // 在图像上绘制人脸区域
            foreach ($faces as $face) {
                opencv_rectangle($frame, $face, opencv_scalar(0, 0, 255));
            }

            // 显示带有人脸区域的图像
            opencv_show_image("Face detection", $frame);

            // 按下ESC键退出循环
            $key = opencv_wait_key(1);
            if ($key === 27) {
                break;
            }
        }

// 释放资源
        opencv_release_capture($capture);


        die;



//        phpinfo();die;

        // 初始化 Guzzle 客户端，指定 Swow 处理器
        $client = new Client([
            'verify' => false,
            'timeout' => 5, // 超时时间（秒）
        ]);

        dump($client->get('http://bus.smart.com/admin-api/test/demo'));die;

        $results = Coroutine::run(function () use (&$client) {
            return $client->get('/admin-api/test/demo');
        });
        dump($results);die;
        die;


        $results = [];
        $wg = new WaitGroup();
        $files = Student::query()->get();
        foreach ($files as $index => $file) {
            $wg->add(); // 增加等待计数
            Coroutine::run(function () use ($wg, $index, $file, &$results) {
                try {
                    // 并发执行任务
                    dump($index . '_' . $file);
                } finally {
                    $wg->done(); // 任务完成，减少等待计数
                }
            });
        }

        die;






        $this->curlTest();
        die;


// Export consumes only a few MB, even with 10M+ rows.
        $users = $this->usersGenerator();
        fastexcel($users)->export('test11111.xlsx');
        die;


        $camera = new \Hanhan1978\OpenCv\Camera();
        $camera->snapshot('test.png');
        dump($camera);die;
        die;

        $webcam = new \VDX\Webcam\Webcam();
        $webcam->setDesiredSize(1280, 720);
        if ($webcam->open()) {
            $webcam->saveFrame('/tmp/test.jpg'/*, true*/); // It accepts a second parameter to mirror the image
            $webcam->close();
        }
        die;

        //$stream = \Ripple\File\File::open(public_path('ipc.log.txt'), 'r');
        //dump($stream);

        //$content = \Ripple\File\File::getContents(public_path('ipc.log.txt'));
        //dump($content);
        //die;

        header('Content-Type: text/event-stream'); //实时流输出
        header('Cache-Control: no-cache'); //不缓存数据
        header('X-Accel-Buffering: no'); // 不缓存数据


        $filename = public_path('273_09_alipay.csv');


        if (($handle = fopen($filename, 'r')) !== false) {
            $i = 0;
            while (($line = fgetcsv($handle, 1000, ',')) !== false) {
                $i++;
                // 处理每一行的数据
                echo '第' . $i++ . '行_' . json_encode($line, JSON_UNESCAPED_UNICODE) . PHP_EOL;
                flush(); // 确保内容即时发送到浏览器
            }
            fclose($handle);
            ob_end_clean(); //清除缓存
        }



//        $file = new SplFileObject($filename);
//        $file->setFlags(SplFileObject::READ_CSV);
//        $file->setCsvControl(',');
//        $i = 0;
//        foreach ($this->fastexcelData($file) as $line) {
//            // 处理每一行的数据
//            echo '第' . $i++ . '行_' . json_encode($line, JSON_UNESCAPED_UNICODE) . PHP_EOL;
//            flush(); // 确保内容即时发送到浏览器
//        }
//        ob_end_clean(); //清除缓存
die;


        foreach ($file as $key => $line) {
            echo $key . PHP_EOL;
            flush(); // 确保内容即时发送到浏览器
            //ob_flush(); // 清空输出缓冲区
        }
        ob_end_clean(); //清除缓存
        die;//必须有，否则会输出header头信息

        $this->curlTest();

        die;

        $id = (new Snowflake)->next();
        dump($id); // 输出一个 64 位的唯一标识符
        $generate = (new Snowflake)->id();
        dump($generate);
        $info = (new Snowflake)->parse($id);
        dump($info);
        die;
        $this->photoBatch();
        die;

        dump(create_secret());die;

        $response = app(DeepseekClient::class)
            ->query('Hello deepseek, how are you ?', 'system')
            ->query('帮我设计一套erp财务系统')
            ->withModel("deepseek-chat")
            ->run();

        dump(json_decode($response, true));

        die;

        // 使用示例
        $columns = table_columns('trade_log');

        dump($columns);die;

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

    function usersGenerator(): Generator
    {
        foreach (Student::cursor() as $user) {
            yield $user;
        }
    }

    public function fastexcelData($file): Generator
    {
        try {
            //$collection = \Ripple\File\File::getContents(public_path('ipc.log.txt'));
            //$collection = (new FastExcel)->import(public_path('273_09_alipay.csv'))->toArray();
            foreach ($file as $v) {
                yield $v;
            }
        } catch (IOException|UnsupportedTypeException|ReaderNotOpenedException $e) {

        }

    }


    public function curlTest()
    {
        $results = [];
        $wg = new WaitGroup();
        $directory = 'D:/WorkSpace/Git/Coding/photo';
        $files = $this->directoryFileAll($directory);
        foreach ($files as $index => $file) {
            $wg->add(); // 增加等待计数
            Coroutine::run(function () use ($wg, $index, $file, &$results) {
                try {
                    $res = $this->curlUpload($file);
                    // 并发执行任务
                    dump($index . '_' . $file . '_' . $res);
                } finally {
                    $wg->done(); // 任务完成，减少等待计数
                }
            });
        }
    }


    public function curlUpload($file)
    {
        $remoteUrl = 'http://fxc.smart.com/index/common/batch';
        $filePath = realpath($file); // 获取文件绝对路径
        if ($filePath) {
            $cFile = new CURLFile($filePath); // 创建CURLFile对象
            $post = [
                'file' => $cFile
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $remoteUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 禁用证书验证
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 禁用主机名验证
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: multipart/form-data', // 设置内容类型为multipart/form-data，这对于文件上传是必需的
                'Expect:' // 防止服务器自动返回100-continue状态码，这在某些服务器上可能引起问题
            ]);
            curl_exec($ch);
            if (curl_errno($ch)) {
                $file = false;
            }
            curl_close($ch);
            return $file;
        }
    }










    /**
     * 低内存上传文件到远程服务器
     * @return void
     */
    public function photoBatch()
    {
        header('Content-Type: text/event-stream'); //实时流输出
        header('Cache-Control: no-cache'); //不缓存数据
        header('X-Accel-Buffering: no'); //不缓存数据

        $directory = 'D:/WorkSpace/Git/Coding/photo';
        if (!is_dir($directory)) {
            die($directory . '目录不存在');
        }

        $i = 0;
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
        foreach ($files as $file) {
            \Swow\Coroutine::run(function () use (&$i, &$file) {
                if ($file->isFile() && $file->getRealPath()) {
                    $i++;
                    $file_path = str_replace('\\', DIRECTORY_SEPARATOR, $file->getRealPath());
                    $info = pathinfo(strtolower($file_path));
                    if ($info && in_array($info['extension'], ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
                        $info['explode'] = explode('/',$info['filename']);
                        $dirname = $info['dirname'];//路径目录
                        $extension = strtolower($info['extension']) ?? null;//文件后缀
                        $filename = end($info['explode']) ?? null;//文件名
                        $filename = trim(strtolower(preg_replace('/[^a-zA-Z0-9.\s]/', '', $filename)));
                        $pathInfo = pathinfo($filename);
                        $filename = $pathInfo['filename'] ?? null;
                        if ($dirname && $filename && $extension) {
                            $filename = str_replace('jpg', '', $filename);
                            $filtered = explode(' ', $filename);
                            if ($filtered) {
                                $filteredArray = array_filter($filtered, function ($value, $key) {
                                    return strlen($value) > 15; //长度大于15个字符的
                                }, ARRAY_FILTER_USE_BOTH);
                                if ($filteredArray) {
                                    $filename = current($filteredArray);
                                }
                            }
                            if ($filename) {
                                $filename = str_replace('Z','z',$filename);
                                $newFile = $dirname . '/' . $filename . '.' . $extension;
                                @rename($file_path, $newFile);
                                if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                    if (iterator_to_array($this->resizeImageGD($file_path, $newFile, 1000, 1000))) {
                                        $filePath = realpath($newFile); // 获取文件绝对路径
                                        if ($filePath) {
                                            $guzzle = $this->batchGuzzle($filePath); //上传服务器
                                            echo "第{$i}条_" . $guzzle . PHP_EOL;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            });
            //每1万条数据就刷新缓冲区
            if ($i % 5 == 0) {
                flush(); // 确保内容即时发送到浏览器
                //ob_flush(); // 清空输出缓冲区
            }
        }
        \Swow\Sync\waitAll();
        ob_end_clean(); //清除缓存
        die;
    }

    public function batchGuzzle($filePath)
    {
        // 目标URL
        $client = new Client([
            'base_uri' => 'https://api.eduonline-cn.com', // 基础URI
            //'base_uri' => 'http://fxc.smart.com', // 基础URI
            'timeout'  => 0, // 超时时间
            'verify' => false,
            'headers' => ['Content-Type' => 'multipart/form-data']
        ]);
        try {
            $promise = $client->postAsync('/index/common/batch', [
                'multipart' => [
                    [
                        'name'     => 'file', // 表单字段名，根据服务器接收方式调整
                        'contents' => fopen($filePath, 'r'), // 打开文件句柄进行读取
                    ],
                ],
            ]);
            $promise->then(function (ResponseInterface $response) {
                return '成功';
            })->resolve(function (ResponseInterface $response) {
                return $response->getStatusCode();
            });
            $promise->wait();
            return $filePath;
        } catch (Exception $e) {
            return $filePath;
        }
    }

    /**
     * 远程服务器上传
     * @param $files
     * @return Generator
     */
    public function photoBatchUpload($files): Generator
    {
        // 本地文件列表
        $remoteUrl = 'https://api.eduonline-cn.com/index/common/batch';
        //$remoteUrl = 'http://fxc.smart.com/index/common/batch';

        foreach ($files as $file) {
            $filePath = realpath($file); // 获取文件绝对路径
            if ($filePath) {
                $cFile = new CURLFile($filePath); // 创建CURLFile对象
                $post = [
                    'file' => $cFile
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $remoteUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 禁用证书验证
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 禁用主机名验证
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: multipart/form-data', // 设置内容类型为multipart/form-data，这对于文件上传是必需的
                    'Expect:' // 防止服务器自动返回100-continue状态码，这在某些服务器上可能引起问题
                ]);
                curl_exec($ch);
                if (curl_errno($ch)) {
                    $file = false;
                }
                yield $file;
                curl_close($ch);
            }
            yield null;
        }
        die;
    }

    /**
     * 获取目录下所有文件
     * @param $directory
     * @return Generator
     */
    public function directoryFileAll($directory): Generator
    {
        $files = [];
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $file_path = str_replace('\\', '/', $file->getRealPath());
                $info = pathinfo(strtolower($file_path));
                if ($info && in_array($info['extension'], ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
                    $info['explode'] = explode('/',$info['filename']);
                    $dirname = $info['dirname'];//路径目录
                    $extension = $info['extension'] ?? null;//文件后缀
                    $filename = end($info['explode']) ?? null;//文件名
                    $filename = trim(strtolower(preg_replace('/[^a-zA-Z0-9.\s]/', '', $filename)));
                    $pathInfo = pathinfo($filename);
                    $filename = $pathInfo['filename'] ?? null;
                    if ($dirname && $filename && $extension) {
                        $filename = str_replace('jpg', '', $filename);

                        $filtered = explode(' ', $filename);
                        if ($filtered) {
                            $filteredArray = array_filter($filtered, function ($value, $key) {
                                return strlen($value) > 15; //长度大于15个字符的
                            }, ARRAY_FILTER_USE_BOTH);
                            if ($filteredArray) {
                                $filename = current($filteredArray);
                            }
                        }
                        $newFile = $dirname . '/' . $filename . '.' . $extension;
                        @rename($file_path, $newFile);
                        if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif'])) {
                            if (iterator_to_array($this->resizeImageGD($file_path, $newFile, 1000, 1000))) {
                                $files[$filename] = $newFile;
                                yield $newFile;
                            }
                        }
                    }
                }
            }
        }
        return $files;
    }


    public function flushBatch($path = null): void
    {
        $path = $path ?? '/www/wwwroot/api.eduonline-cn.com/uploads/pic';
        //$path = $path ?? 'D:/WorkSpace/Git/GitLab/fxc_adminapi/uploads/pic';
        if($path && is_dir($path)){
            $items = @scandir($path);
            foreach($items as $item) {
                if (!in_array($item, ['.', '..'])) {
                    $pathItem = $path  . '/' . $item;
                    if (is_dir($pathItem)) {
                        $this->flushBatch($path . $item);
                        @rmdir($pathItem);
                    } else {
                        @unlink($pathItem);
                    }
                }
            }
        }
    }

    /**
     * 等比例压缩图片
     * @param $sourcePath
     * @param $targetPath
     * @param $maxWidth
     * @param $maxHeight
     * @return Generator
     */
    public function resizeImageGD($sourcePath, $targetPath, $maxWidth, $maxHeight): Generator
    {
        if (!file_exists($sourcePath)) {
            return false; // 获取信息失败
        }
        $info = @getimagesize($sourcePath) ?? null;
        if (!$info) {
            return false; // 获取信息失败
        }

        list($sourceWidth, $sourceHeight, $type) = $info;

        $mime = $info['mime'];
        // 2. 根据 MIME 类型创建原图资源
        switch ($mime) {
            case 'image/jpeg':
                $originalImage = @imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $originalImage = @imagecreatefrompng($sourcePath);
                break;
            case 'image/gif':
                $originalImage = @imagecreatefromgif($sourcePath);
                break;
            default:
                return false; // 不支持的图片类型
        }
        if (!$originalImage) {
            return false; // 创建图像资源失败
        }

        $ratio_orig = $sourceWidth / $sourceHeight;
        if ($sourceWidth <= $maxWidth && $sourceHeight <= $maxHeight) {
            // 如果图片原始尺寸小于或等于最大尺寸，则不进行压缩
            $img_r = @imagecreatetruecolor($sourceWidth, $sourceHeight);
            $source = @imagecreatefromjpeg($sourcePath); // 根据图片格式调整函数，如 imagecreatefrompng
            if ($source)
            @imagecopyresampled($img_r, $source, 0, 0, 0, 0, $sourceWidth, $sourceHeight, $sourceWidth, $sourceHeight);
        } else {
            if ($maxWidth / $maxHeight > $ratio_orig) {
                $optimalWidth = $maxWidth;
                $optimalHeight = intval($optimalWidth / $ratio_orig);
            } else {
                $optimalHeight = $maxHeight;
                $optimalWidth = intval($optimalHeight * $ratio_orig);
            }
            $img_r = @imagecreatetruecolor($optimalWidth, $optimalHeight);
            @imagecopyresampled($img_r, $originalImage, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $sourceWidth, $sourceHeight);
        }

        // 保存图片到目标路径
        @imagejpeg($img_r, $targetPath); // 根据需要选择正确的函数，如 imagepng
        @imagedestroy($originalImage);
        @imagedestroy($img_r);
        yield $sourcePath;
    }

    /**
     * @param  $picture string 图片数据流 比如file_get_contents(imageurl)返回的东东
     * @param $destfile string 存储路径
     */
    function miniImg(string $picture, string $destfile): Generator
    {
        //获取源图gd图像标识符
        $srcImg = @imagecreatefromstring($picture);
        $srcWidth = imagesx($srcImg);
        $srcHeight = imagesy($srcImg);
        //创建新图
        $newWidth = (int) round($srcWidth / 2);
        $newHeight = (int) round($srcHeight / 2);
        $newImg = @imagecreatetruecolor($newWidth, $newHeight);
        //分配颜色 + alpha，将颜色填充到新图上
        $alpha = @imagecolorallocatealpha($newImg, 0, 0, 0, 127);
        @imagefill($newImg, 0, 0, $alpha);
        //将源图拷贝到新图上，并设置在保存 PNG 图像时保存完整的 alpha 通道信息
        @imagecopyresampled($newImg, $srcImg, 0, 0, 0, 0, $newWidth, $newHeight, $srcWidth, $srcHeight);
        @imagesavealpha($newImg, true);
        @imagepng($newImg,$destfile);
        yield $newImg;
    }














    /**
     * 重点-低内存实时上传
     * @return void
     */
    public function autoPhotoQuery()
    {
        header('Content-Type: text/event-stream'); //实时流输出
        header('Cache-Control: no-cache'); //不缓存数据
        header('X-Accel-Buffering: no'); // 不缓存数据

        $school_id = request()->get('school_id') ?? null;

        if (!$school_id) {
            dump('学校id不能为空:school_id');die;
        }

        $i = 0;
        foreach($this->autoPhotoQueryGenerator($school_id) as $item) {
            $i++;
            echo "第{$i}条" . $item . PHP_EOL;
            flush(); // 确保内容即时发送到浏览器
            ob_flush(); // 清空输出缓冲区
        }
        ob_end_clean(); //清除缓存
        die;//必须有，否则会输出header头信息
    }
    public function autoPhotoQueryGenerator($school_id = null): \Generator
    {
        $student =  Db::name('school_student')
            ->where('have_door_photo', 2)
            ->whereNull('deletetime')
            ->when($school_id, function($query) use (&$school_id) {
                $query->where('school_id', $school_id);
            })
            ->cursor();
        if ($student) {
            foreach ($student as $item) {
                $data = [];
                $face_img = 'http://bjylt.oss-cn-chengdu.aliyuncs.com/image/mj/2025-06/19/' . strtolower($item['id_number'] ?? $item['student_sn']) . '.jpg';
                $exists = $this->checkRemoteImageExists($face_img);
                if (!$exists) {
                    $directory = 'D:/WorkSpace/Git/Coding/photo';
                    $fileName = strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($item['id_number'] ?? $item['student_sn'])));
                    $face_img = $this->searchFileInDirectory($directory, $fileName);
                    $exists = (bool) $face_img;
                }
                $data['have_door_photo'] = $exists ? 1 : 2;
                $data['face_img'] = $exists ? $face_img : null;
                $data['picture'] = !$item['picture'] && $exists ? $face_img : null;
                Db::name('school_student')->where('id', $item['id'])->update($data);
                yield '学生-' . $item['name'] . '-' . ($item['id_number'] ?? $item['student_sn']);
            }
        }

        $staff = Db::name('school_staff')
            ->alias('a')
            ->leftjoin('school_staff_relation b ', 'a.id=b.staff_id')
            ->field('a.id,a.name,a.id_number,a.picture,b.face_img,b.get_door_photo')
            ->where('b.school_id', $school_id)
            ->where('b.get_door_photo', 2)
            ->whereNull('a.deletetime')
            ->whereNotNull('b.id')
            ->cursor();
        if ($staff) {
            foreach ($staff as $item) {
                $data = [];
                $face_img = 'http://bjylt.oss-cn-chengdu.aliyuncs.com/image/mj/2025-06/19/' . strtolower($item['id_number'] ?? $item['student_sn']) . '.jpg';
                $exists = $this->checkRemoteImageExists($face_img);
                if (!$exists) {
                    $directory = 'D:/WorkSpace/Git/Coding/photo';
                    $fileName = strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', ($item['id_number'] ?? $item['student_sn'])));
                    $face_img = $this->searchFileInDirectory($directory, $fileName);
                    $exists = (bool) $face_img;
                }
                $data['face_img'] = $exists ? $face_img : null;
                $data['picture'] = !$item['picture'] && $exists ? $face_img : null;
                Db::name('school_staff')->where('id', $item['id'])->update($data);
                unset($data['picture']);
                $data['get_door_photo'] = $exists ? 1 : 2;
                Db::name('school_staff_relation')->where('staff_id', $item['id'])->update($data);
                yield '老师-' . $item['name'] . '-' . ($item['id_number'] ?? $item['student_sn']);
            }
        }
        die;
    }

    function searchFileInDirectory($directory, $filename)
    {
        $files = [];
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $file_path = str_replace('\\', '/', $file->getRealPath());
                $info = explode('/', $file_path);
                $info = pathinfo(end($info));
                $key = strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $info['filename']));

                $files[$key] = $file_path;
            }
        }
        $file = $files[$filename] ?? null;
        return $this->upload_aliYun_oss($file, $filename);
    }


    public static function upload_aliYun_oss($file, $filename)
    {
        $Filesystem = \think\facade\Config::get('aliyun.aliyun_oss');
        $accessKeyId = $Filesystem['accessId'];
        $accessKeySecret =  $Filesystem['accessSecret'];//阿里云后台获取秘钥
        $endpoint = $Filesystem['endpoint'];
        $bucket = $Filesystem['bucket'];
        //实例化对象 将配置传入
        $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
        $pathName = 'image/'.date('Y-m/d') . '/' .strtolower($filename) . '.jpg';
        if ($file) {
            $result = $ossClient->uploadFile($bucket, $pathName, $file);
            return $result['oss-request-url'] ?? null;
        }
        return false;
    }




    //根据上传图片更新学生和老师face_img
    public function fileUpdate()
    {
        header('Content-Type: text/event-stream'); //实时流输出
        header('Cache-Control: no-cache'); //不缓存数据
        header('X-Accel-Buffering: no'); // 不缓存数据

        $i = 0;
        foreach($this->fileUpdateGenerator() as $item) {
            $i++;
            echo "第{$i}条" . $item . PHP_EOL;
            //每1万条数据就刷新缓冲区
            if ($i % 10 == 0) {
                flush(); // 确保内容即时发送到浏览器
                //ob_flush(); // 清空输出缓冲区
            }

        }
        ob_end_clean(); //清除缓存
        die;//必须有，否则会输出header头信息
    }

    public function fileUpdateGenerator(): Generator
    {
        $files = [];
        $directory = realpath(root_path('uploads/pic'));
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $file_path = str_replace('\\', '/', $file->getRealPath());
                $info = explode('/', $file_path);
                $info = pathinfo(end($info));
                $key = strtolower((string) preg_replace('/[^a-zA-Z0-9\s]/', '', $info['filename']));
                $files[$key] = $file_path;
            }
        }
        if ($files) {
            foreach ($files as $key => $file) {
                $sql = "select id from fa_school_student where (id_number='$key' or student_sn='$key') and (face_img is null or face_img='' or have_door_photo=2) AND deletetime is null";
                if ($rows = Db::query($sql)) {
                    $ids = array_column($rows, 'id');
                    if ($face_img = $this->upload_aliYun_oss($file, $key)) {
                        if (SchoolStudent::whereIn('id', $ids)->update(['picture' => $face_img, 'face_img' => $face_img, 'have_door_photo' => 1])) {
                            yield $key .'->'. $face_img;
                        } else {
                            yield $key;
                        }
                    } else {
                        yield $key;
                    }
                } else {
                    $sql = "SELECT b.id,b.staff_id FROM fa_school_staff a, fa_school_staff_relation b
                        WHERE a.id=b.staff_id
                          AND (a.id_number='$key' OR work_sn='$key')
                          AND (b.face_img is null OR b.face_img='' OR b.get_door_photo=2)
                          AND a.deletetime is null
                    ";
                    if ($rows = Db::query($sql)) {
                        $ids = array_column($rows, 'id');
                        $staff_ids = array_column($rows, 'staff_id');
                        if ($face_img = $this->upload_aliYun_oss($file, $key)) {
                            yield (new Db)->transaction(function () use ($key, $file, $ids, $staff_ids, $face_img) {
                                if(SchoolStaffRelation::whereIn('id', $ids)->update(['face_img' => $face_img, 'get_door_photo' => 1])) {
                                    if (SchoolStaff::whereIn('id', $staff_ids)->update(['picture' => $face_img, 'face_img' => $face_img])) {
                                        return $key .'->'. $face_img;
                                    } else {
                                        return $key;
                                    }
                                } else {
                                    return $key;
                                }
                            });
                        } else {
                            yield $key;
                        }
                    } else {
                        yield $key;
                    }
                    @unlink($file); // 删除当前图片
                }
            }
        } else {
            yield false;
        }
    }




    function checkRemoteImageExists($url): bool
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_NOBODY, true); // 仅获取头部信息
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // 允许重定向
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10); // 最大重定向次数
        curl_exec($curl);
        $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return $responseCode === 200;
    }

    /*
    多线程获取网页源码
    @param array $urls
    @return array
*/

    function curl_multi($urls)
    {
        if (!is_array($urls) or count($urls) == 0) {
            return false;
        }
        $num = count($urls);
        $curl = $curl2 = $text = array();
        $handle = curl_multi_init();
        function createCh($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn; R815T Build/JOP40D) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/4.5 Mobile Safari/533.1');
            //设置头部
            curl_setopt($ch, CURLOPT_REFERER, $url); //设置来源
            curl_setopt($ch, CURLOPT_ENCODING, "gzip"); // 编码压缩
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); //是否采集301、302之后的页面
            curl_setopt($ch, CURLOPT_MAXREDIRS, 5); //查找次数，防止查找太深
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            curl_setopt($ch, CURLOPT_HEADER, 0); //输出头部
            return $ch;
        }
        //准备分配线程
        foreach ($urls as $k => $v) {
            $url = $urls[$k];
            $curl[$k] = createCh($url);
            //向curl批处理会话中添加单独的curl句柄
            curl_multi_add_handle($handle, $curl[$k]);
        }
        $active = 0;
        do {
            //运行当前 cURL 句柄的子连接
            $mrc = curl_multi_exec($handle, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);

        while ($active && $mrc == CURLM_OK) {
            //等待所有cURL批处理中的活动连接
            if (curl_multi_select($handle) != -1) {
                usleep(100);
            }
            do {
                //运行当前 cURL 句柄的子连接
                $mrc = curl_multi_exec($handle, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        }

        foreach ($curl as $k => $v) {
            if (curl_error($curl[$k]) == "") {
                //如果没有报错则将获取到的字符串添加到数组中
                $text[$k] = (string) curl_multi_getcontent($curl[$k]);
            }
            //移除并关闭curl该句柄资源
            curl_multi_remove_handle($handle, $curl[$k]);
            curl_close($curl[$k]);
        }
        //关闭cURL句柄
        curl_multi_close($handle);
        //将数组返回
        return $text;
    }


    public function demo()
    {
        $wg = new WaitGroup();
        $model = new Student();
        $results = [];
        $data = $model->query()->limit(2)->select(['id','student_name'])->get()->toArray();
        foreach ($data as $item) {
            Coroutine::run(function () use (&$results, &$item) {
                $results[] = $item;
            });
        }
        dump($results);die;
        //$results = (new \Swow\Sync\WaitGroup)->wait(-1);
        return response()->json($results);
    }

    public function batch()
    {
        $model = new Student;
        $demo_model = new StudentDemo;
        $items = $model->query()
            ->orderBy('id')
            //->limit(100)
            ->lazy(10000)
            ->collect();
        $chunks = $items->chunk(1000);
        foreach ($chunks as $chunk) {
            //Coroutine::run(function () use ($chunk) {
                //$this->chunkInsert($chunk->toArray());
            //});
            \Co\async(function () use(&$chunk) {
                $res = $this->chunkInsert($chunk->toArray());
                dump($res);
            });


//            new Fiber(function () use($chunk) {
//                try {
//                    $res = $this->chunkInsert($chunk->toArray());
//                    Fiber::suspend($res);
//                } catch (\Throwable $e) {
//                    Fiber::suspend($e->getMessage());
//                }
//            });



        }
        \Co\wait();
        //dump($chunks);
        die;

        $groupedItems = array_reduce($items, function ($carry, $item) {
            $key = $item['category']; // 分组的键是 'category' 字段
            if (!isset($carry[$key])) {
                $carry[$key] = []; // 如果键不存在，初始化一个空数组
            }
            $carry[$key][] = $item; // 将当前元素添加到对应组的数组中
            return $carry;
        }, []);


    }


    public function chunkInsert($data): int
    {
     $model = new StudentDemo();
     return $model->query()->insertOrIgnore($data);
    }


}
