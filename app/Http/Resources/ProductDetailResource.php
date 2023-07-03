<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'keywords' => $this->keywords,
            'waktu_penyelesaian' => $this->waktu_penyelesaian,
            'batas_revisi' => $this->batas_revisi,
            'price' => $this->price,
            'image' => $this->image,
            'description' => $this->description,
            'category' => $this->category,
            'store' => $this->store
        ];
    }
}