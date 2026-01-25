<?php
declare(strict_types=1);
namespace App\Library;


class SwowTimer
{
    /**
     * 单次定时任务
     * @param float $delay 延迟秒数
     * @param callable $callback 任务回调
     * @return int 定时器ID
     */
    public static function once(float $delay, callable $callback): int
    {
        return EventLoop::getInstance()->delay($delay, $callback);
    }

    /**
     * 循环定时任务
     * @param float $interval 执行间隔秒数
     * @param callable $callback 任务回调
     * @return int 定时器ID
     */
    public static function loop(float $interval, callable $callback): int
    {
        return EventLoop::get()->repeat($interval, $callback);
    }

    /**
     * 取消定时任务
     * @param int $timerId 定时器ID
     */
    public static function cancel(int $timerId): void
    {
        EventLoop::get()->cancel($timerId);
    }

    /**
     * 启动事件循环
     */
    public static function start(): void
    {
        EventLoop::get()->run();
    }

}
