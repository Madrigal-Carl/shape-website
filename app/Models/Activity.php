<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
    ];

    protected $casts = [
        'category' => 'array',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'loggable');
    }
    public function latestLogForStudent($studentId)
    {
        return $this->logs()
            ->where('student_id', $studentId)
            ->orderByDesc('attempt_number')
            ->first();
    }
}
