<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Order;
class OrderResource extends JsonResource
{
    private $orderId;
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return Order::findOrFail($this->orderId);
    }
}
