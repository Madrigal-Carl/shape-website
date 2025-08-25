<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
    ];

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function lessonSubjectStudents()
    {
        return $this->hasMany(LessonSubjectStudent::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function isCompletedByStudent($studentId)
    {
        // Check all quizzes
        if ($this->quizzes->contains(function($quiz) use ($studentId) {
            $log = $quiz->latestLogForStudent($studentId);
            return !$log || $log->status !== 'completed';
        })) {
            return false;
        }

        // Check all activities
        if ($this->activities->contains(function($activity) use ($studentId) {
            $log = $activity->latestLogForStudent($studentId);
            return !$log || $log->status !== 'completed';
        })) {
            return false;
        }

        return true;
    }

}
