<?php

namespace App\Mail\Admin;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     */
    public function __construct($order)
    {
        $this->order = $order;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $id = $this->order->id;
        $fields = $this->order->orderProductsDetail()
            ->get(['name','quantity']);
        $orderPrice = $this->order->getTotalPrice();
        return $this->view('admin.emails.order')
            ->with(compact('id', 'fields', 'orderPrice'))
            ->subject('Заказ №' . $this->order->id . ' завершен');
    }
}
