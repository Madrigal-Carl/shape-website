<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\LessonResource;
use App\Models\Lesson;
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
        $schoolYear = now()->schoolYear();
        $currentQuarter = $schoolYear?->currentQuarter();

        // ✅ Handle case when no active school year or quarter is found
        if (!$schoolYear || !$currentQuarter) {
            $lessons = collect();
        } else {
            $lessons = Lesson::where('school_year_id', $schoolYear->id)
                ->get()
                ->filter(fn($lesson) => $lesson->isInQuarter($schoolYear, $currentQuarter));
        }

        return [
            'student' => [
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
            ],
            'lessons' => LessonResource::collection($lessons),
        ];
    }
}
