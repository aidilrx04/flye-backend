<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'rating' => $this->rating,
            'description' => $this->description,
            'tagline' => $this->tagline,
            'image_urls' => collect($this->image_urls)->map(fn($val) => url('/storage/' . $val)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
