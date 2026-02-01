<?php

$server = new \Swow\Psr7\Server\Server();
$server->bind('0.0.0.0', 9503)->listen();

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
