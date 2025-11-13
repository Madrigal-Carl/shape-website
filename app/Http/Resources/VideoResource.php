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
        // Helper function to determine if URL is external
        $formatUrl = function (?string $url): ?string {
            if (!$url) return null;
            if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
                return $url;
            }
            return asset('storage/' . $url);
        };

        return [
            'id'        => $this->id,
            'lesson_id' => $this->lesson_id,
            'title'     => $this->title,
            'url'       => $formatUrl($this->url),
            'thumbnail' => $this->thumbnail ? asset('storage/' . $this->thumbnail) : null,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
            'deleted_at' => $this->deleted_at?->toDateTimeString(),
        ];
    }
}
