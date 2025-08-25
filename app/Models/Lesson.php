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

    public function activityLessons()
    {
        return $this->hasMany(ActivityLesson::class);
    }

    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            LessonSubjectStudent::class,
            'lesson_id',
            'id',
            'id',
            'student_id'
        );
    }
    public function isCompletedByStudent($studentId)
    {
        foreach ($this->quizzes as $quiz) {
            $log = $quiz->logs()->where('student_id', $studentId)->latest('attempt_number')->first();
            if (!$log || $log->status !== 'completed') {
                return false;
            }
        }

        foreach ($this->activityLessons as $activityLesson) {
            $log = $activityLesson->logs()->where('student_id', $studentId)->latest('attempt_number')->first();
            if (!$log || $log->status !== 'completed') {
                return false;
            }
        }

        return true;
    }
}
