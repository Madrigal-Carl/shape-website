<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'instructor_id',
        'path',
        'first_name',
        'middle_name',
        'last_name',
        'sex',
        'birth_date',
        'status',
    ];

    public function account()
    {
        return $this->morphOne(Account::class, 'accountable');
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'owner');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function guardian()
    {
        return $this->hasOne(Guardian::class);
    }

    public function lessonSubject()
    {
        return $this->hasMany(LessonSubject::class);
    }

    public function lessons()
    {
        return $this->hasManyThrough(
            Lesson::class,
            LessonSubject::class,
            'student_id',
            'lesson_subject_id',
            'id',
            'id'
        );
    }

    public function getCompletedLessonsCountAttribute()
    {
        return $this->lessons->filter(function ($lesson) {
            $quizzesDone = $lesson->quizzes->every(fn($quiz) =>
                $quiz->progress->where('status', 'completed')->isNotEmpty()
            );

            $activitiesDone = $lesson->activityLessons->every(fn($activity) =>
                $activity->progress->where('status', 'completed')->isNotEmpty()
            );

            return $quizzesDone && $activitiesDone;
        })->count();
    }

    public function getTotalLessonsCountAttribute()
    {
        return $this->lessons->count();
    }

    public function getCompletedQuizzesCountAttribute()
    {
        return $this->lessons->flatMap->quizzes->filter(fn($quiz) =>
            $quiz->progress->where('status', 'completed')->isNotEmpty()
        )->count();
    }

    public function getTotalQuizzesCountAttribute()
    {
        return $this->lessons->flatMap->quizzes->count();
    }

    public function getCompletedActivitiesCountAttribute()
    {
        return $this->lessons->flatMap->activityLessons->filter(fn($activity) =>
            $activity->progress->where('status', 'completed')->isNotEmpty()
        )->count();
    }

    public function getTotalActivitiesCountAttribute()
    {
        return $this->lessons->flatMap->activityLessons->count();
    }

}
