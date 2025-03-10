<?php

namespace App\Http\Resources\CMS;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchesResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'contact' => $this->contact,
            'mapUrl' => $this->map_url,
            'address' => $this->address,
            'banks' => $this->banks,
            'sequenceOrder' => $this->sequence_order,
            'createdAtStr' => $createdAtStr,
            'createdAt' => $createdAt,
        ];
    }
}
