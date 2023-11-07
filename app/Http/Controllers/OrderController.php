<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Business\OrderServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Order;

class OrderController extends Controller
{
    private OrderServices $orderService;

    public function __construct(OrderServices $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        /*return response()->json([
            'data' => $this->orderService->getAllOrders()
        ]);*/
        return response()->json(new OrderCollection(Order::all()));
    }

    public function store(Request $request)
    {
        $return = $this->orderService->createOrder($request);
        return response()->json($return->body, $return->status);
    }

    public function show(Request $request)
    {
        $orderId = $request->route('id');
        //$order = new OrderResource(Order::findOrFail($orderId));
        $order = new OrderResource($orderId);

        return $order;
    }

    public function update(Request $request)
    {
        $orderId = $request->route('id');
        $orderDetails = $request->only([
            'client',
            'details'
        ]);

        return response()->json([
            'data' => $this->orderRepository->updateOrder($orderId, $orderDetails)
        ]);
    }

    public function destroy(Request $request)
    {
        $orderId = $request->route('id');
        $this->orderRepository->deleteOrder($orderId);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
