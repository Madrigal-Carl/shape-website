<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // Account fields (comes from morphOne relation)
            'id'       => $this->account?->id,
            'username' => $this->account?->username,

            // Student fields (attributes from Student model)
            'student_id' => $this->id,
            'path'   => $this->path ? asset('storage/' . $this->path) : null,
            'fullname'       => $this->full_name,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name'  => $this->last_name,
            'sex'        => $this->sex,
            'birth_date' => $this->birth_date?->toDateString(),
            'lrn'        => $this->lrn,
            'disability_type' => $this->disability_type,
            'support_need' => $this->support_need,
            'status'     => $this->status,

            // Relationships
            'permanent_address' => $this->whenLoaded('permanentAddress'),
            'current_address'   => $this->whenLoaded('currentAddress'),
            'guardian'          => $this->whenLoaded('guardian'),
            'created_at'        => $this->created_at?->toDateTimeString(),
        ];
    }
}
