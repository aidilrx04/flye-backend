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
            ...parent::toArray($request),
            'image_urls' => collect($this->image_urls)->map(fn($val) => strpos($val, 'http') !== false ? $val : url('/storage/' . $val)),
        ];
    }
}
