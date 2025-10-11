<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'lesson_id' => $this->lesson_id,
            'title'     => $this->title,
            'url'       => $this->url ? asset('storage/' . $this->url) : null,
            'thumbnail' => $this->thumbnail ? asset('storage/' . $this->thumbnail) : null,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
