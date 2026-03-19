<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification
{
    use Queueable;

    // 可以在构造函数中接收数据
    public function __construct(protected $order)
    {
        //
    }

    /**
     * 获取通知的传递渠道。
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
     * 获取通知的邮件表示形式。
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('您的订单已发货')
            ->greeting('您好，' . $notifiable->name . '!')
            ->line('您的订单 #' . $this->order->id . ' 已经发货。')
            ->line('预计送达时间：3-5 个工作日。')
            ->action('查看订单', url('/orders/' . $this->order->id))
            ->line('感谢您的购买！');
    }

    /**
     * 获取通知的数组表示形式（可选，用于数据库驱动）。
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray(mixed $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'status' => 'shipped',
        ];
    }
}
