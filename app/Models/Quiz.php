<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function activityLesson()
    {
        return $this->hasOne(ActivityLesson::class);
    }

    public function latestLogForStudent($studentId)
    {
        if (!$this->lessonQuiz) return null;

        return $this->lessonQuiz->logs()
            ->where('student_id', $studentId)
            ->latest('attempt_number')
            ->first();
    }
}
