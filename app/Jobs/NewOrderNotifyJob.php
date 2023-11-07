<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\Helper;
class NewOrderNotifyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $productName = $this->data->productName;
        $productPrice = $this->data->productPrice;
        $qty = $this->data->qty;
        $total = $this->data->total;
        $customerName = $this->data->customerName;
        $message = "คุณ $customerName ได้ทำการสั่งซื้อ $productName ราคา $productPrice บาท จำนวน $qty ชิ้น เป็นเงิน $total บาท";
        echo ('Job new order notify is started...');
        Helper::EmailSend([
            'name' => 'Admin',
            'email' => 'sakda.jump@gmail.com',
            'subject' => 'New Order !!!!!',
            'message' => $message,
        ]);
        echo ('Job new order notify is successfully !!');
    }
}
