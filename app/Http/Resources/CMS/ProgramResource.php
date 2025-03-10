<?php

namespace App\Http\Resources\CMS;

use App\Http\Resources\FileResource;
use App\Http\Resources\ProgramScheduleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
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

        // Get start price
        $highestDiscounts = $this->whenLoaded('discounts', fn() => $this->discounts->first(), null);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'overview' => $this->overview,
            'facility' => $this->facility,
            'benefits' => $this->benefits,
            'detailedInformations' => $this->detailed_informations,
            'startPrice' => $this->price - (int) $highestDiscounts?->pivot->amount,
            'price' => $this->price,
            'grade' => $this->grade,
            'level' => $this->level,
            'images' => $images ?? [],
            'participantCount' => $this->participant_count,
            'remainingQuota' => $this->remaining_quota,
            'branch' => new BranchesResource($this->whenLoaded('branch')),

            'discounts' => ProgramDiscountResource::collection($this->whenLoaded('discounts')),
            'schedules' => ProgramScheduleResource::collection($this->whenLoaded('schedule')),
        ];
    }
}
