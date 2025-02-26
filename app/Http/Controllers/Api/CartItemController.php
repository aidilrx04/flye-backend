<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBulkCartItemRequest;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Resources\CartItemResouce;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $cart_items = QueryBuilder::for($user->cart_items())
            ->defaultSort('-created_at')
            ->allowedSorts(['quantity', 'product_id', 'id', 'user_id', 'created_at', 'updated_at'])
            ->get();

        return CartItemResouce::collection($cart_items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartItemRequest $request)
    {
        $user = $request->user();
        $safe = $request->safe();

        $cart_item = $user->cart_items()->create([
            'product_id' => $safe->product_id,
            'quantity' => $safe->quantity,
        ]);

        // load all new
        $cart_item->product;
        $cart_item->user;


        return new CartItemResouce($cart_item);
    }

    public function store_bulk(StoreBulkCartItemRequest $request)
    {
        $user = $request->user();
        $safe = $request->safe();

        $cart_items = [];

        foreach ($safe->items as $item) {
            $cart_item = $user->cart_items()->create([
                'quantity' => $item['quantity'],
                'product_id' => $item['product_id']
            ]);

            array_push($cart_items, $cart_item);
        }

        return CartItemResouce::collection($cart_items);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(CartItem $cart)
    {
        $cart->delete();
        return response()->json(null, 204);
    }
}
