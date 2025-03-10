<?php

namespace App\Http\Resources\CMS;

use App\Http\Resources\FileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramDiscountResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'startDate' => $this->start_date,
            'endDate' => $this->end_date,
            'rate' => $this->rate,
            'image' => new FileResource(json_decode(json_encode($this->image))),
            'amount' => $this->pivot?->amount,
        ];
    }
}
