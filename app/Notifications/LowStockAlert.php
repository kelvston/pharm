<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowStockAlert extends Notification
{
    use Queueable;

    public $item;

    public function __construct($item)
    {
        $this->item = $item;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Sends email and in-app notification
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Low Stock Alert')
            ->line('The stock for ' . $this->item->product_name . ' is low.')
            ->line('Current Quantity: ' . $this->item->quantity);
    }

    public function toDatabase($notifiable)
    {
        return [
            'product_name' => $this->item->product_name,
            'quantity' => $this->item->quantity,
        ];
    }

}
