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

    public function lessonQuizzes()
    {
        return $this->hasMany(LessonQuiz::class);
    }

    public function activityLessons()
    {
        return $this->hasMany(ActivityLesson::class);
    }

    public function isCompletedByStudent($studentId)
    {
        // Check all quizzes
        foreach ($this->lessonQuizzes as $lessonQuiz) {
            $log = $lessonQuiz->logs()->where('student_id', $studentId)->latest('attempt_number')->first();
            if (!$log || $log->status !== 'completed') {
                return false;
            }
        }

        // Check all activities
        foreach ($this->activityLessons as $activityLesson) {
            $log = $activityLesson->logs()->where('student_id', $studentId)->latest('attempt_number')->first();
            if (!$log || $log->status !== 'completed') {
                return false;
            }
        }

        return true;
    }


}
