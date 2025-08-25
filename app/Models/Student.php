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

    public function addresses()
    {
        return $this->morphMany(Address::class, 'owner');
    }

    public function permanentAddress()
    {
        return $this->morphOne(Address::class, 'owner')->where('type', 'permanent');
    }

    public function currentAddress()
    {
        return $this->morphOne(Address::class, 'owner')->where('type', 'current');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function guardian()
    {
        return $this->hasOne(Guardian::class);
    }

    public function lessonSubjectStudents()
    {
        return $this->hasMany(LessonSubjectStudent::class);
    }

    public function lessons()
    {
        return $this->hasManyThrough(
            Lesson::class,
            LessonSubjectStudent::class,
            'student_id',
            'id',
            'id',
            'lesson_id'
        );
    }

    public function getTotalLessonsCountAttribute() {
        return $this->lessonSubjectStudents->count();
    }

    // Completed lessons count
    public function getCompletedLessonsCountAttribute() {
        return $this->lessonSubjectStudents->filter(function($lss) {
            return $lss->lesson->isCompletedByStudent($this->id);
        })->count();
    }

    // Total quizzes count
    public function getTotalQuizzesCountAttribute()
    {
        return $this->lessonSubjectStudents->filter(fn ($lss) => $lss->lesson->quiz !== null)->count();
    }

    // Completed quizzes count
    public function getCompletedQuizzesCountAttribute()
    {
        return $this->lessonSubjectStudents->filter(function ($lss) {
            $quiz = $lss->lesson->quiz;
            if (!$quiz) return false;

            $log = $quiz->latestLogForStudent($this->id);
            return $log && $log->status === 'completed';
        })->count();
    }

    // Total activities count
    public function getTotalActivitiesCountAttribute() {
        return $this->lessonSubjectStudents->sum(function($lss) {
            return $lss->lesson->activityLessons->count();
        });
    }

    // Completed activities count
    public function getCompletedActivitiesCountAttribute() {
        return $this->lessonSubjectStudents->sum(function($lss) {
            return $lss->lesson->activityLessons->filter(function($activityLesson) {
                $log = $activityLesson->logs()
                    ->where('student_id', $this->id)
                    ->latest('attempt_number')
                    ->first();

                return $log && $log->status === 'completed';
            })->count();
        });
    }

}
