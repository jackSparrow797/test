<?php

namespace App\Observers\Admin;

use App\Mail\Admin\OrderMail;
use App\Order;
use App\Repositories\Admin\OrderRepository;
use Mail;

class OrderObserver
{
    private $orderRepository;

    public function __construct()
    {
        $this->orderRepository = app(OrderRepository::class);
    }

    /**
     * Handle the order "created" event.
     *
     * @param Order $order
     * @return void
     */
    public function created(Order $order)
    {

    }

    /**
     * Handle the order "creating" event.
     *
     * @param Order $order
     * @return void
     */
    public function creating(Order $order)
    {

    }

    /**
     * Handle the order "updating" event.
     *
     * @param Order $order
     * @return void
     */
    public function updating(Order $order)
    {

    }

    /**
     * Handle the order "updated" event.
     *
     * @param Order $order
     * @return void
     */
    public function updated(Order $order)
    {
        $dirtyStatus = $order->isDirty('status');
        $isStatusComplite = $order->status == Order::STATUS_MAIL_SEND;
        if ($dirtyStatus && $isStatusComplite) {
            $vendorEmails = $this->orderRepository
                ->getVendorEmailForProduct($order);
            $partnerEmail = $this->orderRepository
                ->getPartnerEmailForOrder($order);
            $emailTo =  array_merge([$partnerEmail], $vendorEmails);
            Mail::to($emailTo)
                ->send(new OrderMail($order));
        }
    }

    /**
     * Handle the order "deleted" event.
     *
     * @param Order $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the order "restored" event.
     *
     * @param Order $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the order "force deleted" event.
     *
     * @param Order $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
