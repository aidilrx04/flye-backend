<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(9);

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $safe = $request->safe();

        $uploaded_image = [];

        $images = $request->file('images');
        foreach ($images as $image) {
            // upload images
            $image_path = $image->store(null, 'public');
            array_push($uploaded_image, $image_path);
        }

        // create product
        $product = Product::create([
            'name' => $safe['name'],
            'price' => $safe['price'],
            'description' => $safe['description'],
            'tagline' => $safe['tagline'],
            'rating' => 0,
            'image_urls' => $uploaded_image,
        ]);
        // return product

        return new ProductResource($product);

        return [
            ...$safe,
            'uploaded' => $uploaded_image
        ];

        // $product = Product::create($safe);

        // return $product;
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
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
