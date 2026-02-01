<?php
$server = new \Swow\Socket(\Swow\Socket::TYPE_TCP);
$server->bind('127.0.0.1', 9503)->listen();
while (true) {
    $connection = $server->accept();
    Swow\Coroutine::run(static function () use ($connection): void {
        $buffer = new Swow\Buffer(Swow\Buffer::COMMON_SIZE);
        try {
            while (true) {
                $length = $connection->recv($buffer);
                if ($length === 0) {
                    break;
                }
                echo "No.{$connection->getFd()} say: \"" . addcslashes($buffer->toString(), "\r\n") . '"' . PHP_EOL;
                $connection->send($buffer);
            }
        } catch (Swow\SocketException $exception) {
            echo "No.{$connection->getFd()} goaway! {$exception->getMessage()}" . PHP_EOL;
        }
    });
}
