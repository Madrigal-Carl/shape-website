<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'id' => $this->id,
            'lrn' => $this->lrn,
            'path' => asset('storage/' . $this->path),
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'fullname' => $this->full_name,
            'sex' => $this->sex,
            'birth_date' => $this->birth_date instanceof Carbon
                ? $this->birth_date->toDateString()
                : $this->birth_date,
            'disability_type' => $this->disability_type,
            'support_need' => $this->support_need,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
