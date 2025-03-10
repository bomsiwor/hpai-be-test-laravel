<?php

namespace App\Http\Resources\Registrations;

use App\Http\Resources\CMS\BranchesResource;
use App\Http\Resources\CMS\ProgramResource;
use App\Http\Resources\FileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationResource extends JsonResource
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
            'uniqueKey' => $this->unique_key,
            'status' => $this->status,
            'fullName' => $this->full_name,
            'address' => $this->address,
            'dob' => $this->dob,
            'gender' => $this->gender,
            'school' => $this->school,
            'email' => $this->email,
            'mobilePhone' => $this->mobile_phone,
            'parentFullName' => $this->parent_full_name,
            'parentAddress' => $this->parent_address,
            'parentOccupancy' => $this->parent_occupancy,
            'parentEmail' => $this->parent_email,
            'parentPhone' => $this->parent_phone,
            'parentGender' => $this->parent_gender,
            'programId' => $this->program_id,
            'program' => new ProgramResource($this->whenLoaded('program')),
            'discount' => $this->discount,
            'amount' => $this->amount,
            'netAmount' => $this->net_amount,
            'paymentType' => $this->payment_type,
            'dp' => $this->dp,
            'paymentProof' => $this->payment_proof ? new FileResource($this->payment_proof) : null,
            'paidAt' => $this->paid_at,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'invalidReason' => $this->invalid_reason,
        ];
    }
}
