<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\NewOrderNotifyJob;
class SendOrderNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $data = (object)[
            'productName' => $event->productName,
            'productPrice' => $event->productPrice,
            'qty' => $event->qty,
            'total' => $event->total,
            'customerName' => $event->customerName,
        ];
        dispatch(new NewOrderNotifyJob($data));
        //exit;
    }
}
