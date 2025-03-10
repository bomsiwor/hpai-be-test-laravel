<?php

namespace App\Http\Resources\CMS;

use App\Http\Resources\FileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OtherProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Mutate image
        // Encode then decode to create array of object
        if ($this->images) {
            $images = json_decode(json_encode($this->images));

            $images = FileResource::collection(collect($images));
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'discounts' => $this->discounts,
            'images' => $images ?? [],
            'url' => $this->url,
            'createdAt' => $this->created_at->format("Y-m-d H:i:s"),
            'updatedAt' => $this->updated_at->format("Y-m-d H:i:s"),
        ];
    }
}
