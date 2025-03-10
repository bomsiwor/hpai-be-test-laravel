<?php

namespace App\Http\Resources\LandingPage;

use App\Http\Resources\FileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HeroResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->informations;

        // Mutate image
        // Encode then decode to create array of object
        if (isset($data['images'])) {
            $images = json_decode(json_encode($data['images']));

            $data['images'] = FileResource::collection(collect($images));
        }

        if (isset($data['bgImage'])) {
            $images = json_decode(json_encode($data['bgImage']));

            $data['bgImage'] = new FileResource($images);
        }

        return $data;
    }
}
