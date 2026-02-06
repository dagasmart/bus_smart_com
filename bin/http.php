<?php

/**
 * This file is part of Swow
 *
 * @link    https://github.com/swow/swow
 * @contact twosee <twosee@php.net>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code
 */

declare(strict_types=1);

use Swow\Buffer;
use Swow\Coroutine;
use Swow\Socket;
use Swow\SocketException;

$server = new Socket(Socket::TYPE_TCP);
$server->bind('127.0.0.1', 9764)->listen();
while (true) {
    $connection = $server->accept();


    while (true) {
        $connection = $server->acceptConnection();
        \Swow\Coroutine::run(static function () use ($connection): void {
            try {
                while (true) {
                    $request = null;
                    try {
                        $request = $connection->recvHttpRequest();
                        if ($request->getUri()->getPath() === '/') {
                            $connection->respond('22222');
                        }
                    } catch (Throwable $exception) {
                    }
                }
            } catch (Throwable $exception) {
            }
        });
    }

//    Coroutine::run(static function () use ($connection): void {
//        $buffer = new Buffer(Buffer::COMMON_SIZE);
//        try {
//            while (true) {
//                $length = $connection->recv($buffer, $buffer->getLength());
//                if ($length === 0) {
//                    break;
//                }
//                while (true) {
//                    $eof = strpos($buffer->toString(), "\r\n\r\n");
//                    if ($eof === false) {
//                        break;
//                    }
//                    $connection->send(
//                        "HTTP/1.1 200 OK\r\n" .
//                        "Connection: keep-alive\r\n" .
//                        "Content-Length: 0\r\n\r\n"
//                    );
//                    $requestLength = $eof + strlen("\r\n\r\n");
//                    $buffer->truncateFrom($requestLength);
//                }
//            }
//        } catch (SocketException $exception) {
//            echo "No.{$connection->getFd()} goaway! {$exception->getMessage()}" . PHP_EOL;
//        }
//    });
}
