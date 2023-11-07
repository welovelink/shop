<?php

namespace App\Business;

use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Order;
use App\Events\OrderCreated;
class OrderServices
{


    public function __construct()
    {
        //$this->orderRepository = $orderRepository;
    }

    public function getAllOrders()
    {
        //return $this->orderRepository->getAllOrders();
    }

    public function createOrder(Request $request)
    {
        $validator = Validator::make($request->post(), [
            'phone' => 'required',
            'product_code' => 'required',
            'qty' => 'required',
            'delivery_address' => 'required',
            'billing_address' => 'required',
        ]);

        if ($validator->fails()) {
            return (object)[
                'body' => $validator->errors(),
                'status' => Response::HTTP_BAD_REQUEST
            ];
        }

        $product_code = $request->post('product_code');
        $product = Product::where('code', $product_code)->first();
        if (!$product) {
            return (object)[
                'body' => 'Product not found',
                'status' => Response::HTTP_NO_CONTENT
            ];
        }

        $user = auth()->user();
        $order = new Order();
        $order->code = strtoupper(Str::random(15));
        $order->product_code = $product_code;
        $order->cid = $user->id;
        $order->phone = $request->post('phone');
        $order->email = $user->email;
        $order->delivery_address = $request->post('delivery_address');
        $order->billing_address = $request->post('billing_address');
        $order->qty = $request->post('qty');
        $order->summary_price =$order->qty * $product->price;
        $order->created_at = now();
        $order->save();

        $params = (object)[
            'productName' => $product->name,
            'productPrice' => $product->price,
            'qty' => $order->qty,
            'total' => $order->summary_price,
            'customerName' => $user->name
        ];

        event(new OrderCreated($params));

        return (object)[
            'body' => [
                'status' => 'ok'
            ],
            'status' => Response::HTTP_OK
        ];
    }
}
