<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use App\Support\ToyyibPay\ToyyibPay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = QueryBuilder::for(Order::class)
            ->allowedIncludes(['user'])
            ->get();

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $user = $request->user();

        $safe = $request->safe();

        $cart_items = $user->cart_items()->whereIn('id', $safe->items)->get();

        if ($cart_items->count() === 0) {
            return response()->json([
                'message' => 'No cart items found.'
            ], 400);
        }

        $order = $user->orders()->create([
            'total' => 0,
            'shipping_address' => $safe->shipping_address
        ]);


        foreach ($cart_items as $item) {
            $product = Product::find($item['product_id']);

            $order_item = $order->items()->create([
                'quantity' => $item->quantity,
                'product_id' => $item->product_id
            ]);

            $item_total = $order_item->quantity * $product->price;
            $order->total += $item_total;

            // remove cart item
            $item->delete();
        }

        $tax = $order->total * 0.08;
        $order->total += $tax;
        $order->save();

        $order->refresh();

        // create bill for payment
        $bill_code = ToyyibPay::create_bill(
            "Flye Order #" . $order->id,
            "Flye order at flye.com",
            $order->total * 100,
            env('TOYYIBPAY_RETURN_URL'),
            env('TOYYIBPAY_CALLBACK_URL', ''),
            $order->id,
            now()->addHour(2)
        );

        $payment_url = env('TOYYIBPAY_URL') . '/' . $bill_code;


        // create payment details
        $payment = $order->payment()->create([
            'amount' => $order->total,
            'method' => 'toyyibpay',
            'url' => $payment_url,
            'valid_until' => now()->addHour(2),
            'status' => 'PENDING'
        ]);

        // load items to order model
        $order->items;
        $order->payment;

        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order = QueryBuilder::for(Order::class)
            ->allowedIncludes(['user'])
            ->find($order->id);

        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function status(Request $request)
    {
        //TODO(aidil): Handle status gracefully
        $status_id = $request->input('status_id');
        $order_id = $request->input('order_id');

        $order = Order::find($order_id);

        if ($status_id != "1") {
            return;
        }

        $order->update([
            'status' => 'PREPARING'
        ]);

        $order->payment->update([
            'status' => 'SUCCESS'
        ]);

        Log::info($order);

        return;
    }
}
