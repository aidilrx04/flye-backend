<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
    public function update(UpdateProductRequest $request, Product $product)
    {
        $safe = $request->safe();

        // remove old images
        $remove_images = $safe->remove_images ?? [];

        $TEST_IMAGE_URL = 'https://loremflickr.com';

        $existing_images = collect($product->image_urls);
        foreach ($remove_images as $image) {

            if (strpos($image, $TEST_IMAGE_URL) !== false) {
                $existing_images = $existing_images->filter(fn($image_path) => $image_path !== $image);

                continue;
            }

            $filename = basename($image);

            // remove from storage
            Storage::disk('public')->delete($filename);
            $existing_images = $existing_images->filter(fn($image_path) => $image_path !== $filename);
        }
        $product->image_urls = $existing_images->toArray();

        // create new images
        $uploaded_image = $product->image_urls;
        $new_images = $request->file('new_images') ?? [];
        foreach ($new_images as $image) {
            // upload images
            $image_path = $image->store(null, 'public');
            array_push($uploaded_image, $image_path);
        }

        $product->image_urls = $uploaded_image;

        // either set or new thumbnail, cant both
        if ($safe->set_thumbnail) {
            $image_name = basename($safe->set_thumbnail);

            if (strpos($safe->set_thumbnail, $TEST_IMAGE_URL) !== false) {
                $image_name = $safe->set_thumbnail;
            }

            $product->image_urls = [$image_name, ...collect($product->image_urls)->filter(fn($val) => $val !== $image_name)->toArray()];
        } else if ($safe->new_thumbnail) {
            $image_path = $request->file('new_thumbnail')->store(null, 'public');
            $product->image_urls = [$image_path, ...$product->image_urls];
        }


        $product->save();
        $product->update([
            'name' => $safe->name,
            'price' => $safe->price,
            'description' => $safe->description,
            'tagline' => $safe->tagline,
        ]);

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Product deleted'
        ], 204);
    }
}
