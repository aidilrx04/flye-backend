<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
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

        $safe = $request->safe()->all();

        $order = Order::create(['total' => 0]);

        foreach ($safe['items'] as $item) {
            $product = Product::find($item['product_id']);
            $order_item = $order->items()->create([
                'quantity' => $item['quantity'],
                'product_id' => $item['product_id']
            ]);
            $ppq = $order_item->quantity * $product->price;
            $order->total += $ppq;
        }

        $tax = $order->total * 0.08;
        $order->total += $tax;
        $order->save();

        $order->refresh();


        // load items to order model
        $order->items;

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
}
