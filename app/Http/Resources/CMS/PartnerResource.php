<?php

namespace App\Http\Resources\CMS;

use App\Http\Resources\FileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        [$createdAtStr, $createdAt] = humanReadableTimestamps($this->created_at);

        return [
            "id" => $this->id,
            "name" => $this->name,
            "url" => $this->url,
            "isPublished" => $this->is_published,
            "description" => $this->description,
            "images" => new FileResource((object) $this->images),
            "createdAtStr" => $createdAtStr,
            "createdAt" => $createdAt,
        ];
    }
}
