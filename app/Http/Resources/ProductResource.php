<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            "id" => $this->id,
            "name" => $this->name,
            "image" => $this->image_url,
            "stock" => $this->stock,
            "description" => $this->description,
            "price" => $this->price_rupiah,
        ];
    }
}
