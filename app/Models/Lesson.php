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
        foreach ($this->activityLessons as $activityLesson) {
            $studentActivity = $activityLesson->studentActivities()
                ->where('student_id', $studentId)
                ->first();

            if (!$studentActivity) {
                return false;
            }

            $log = $studentActivity->logs()
                ->latest('attempt_number')
                ->first();

            if (!$log || $log->status !== 'completed') {
                return false;
            }
        }

        return true;
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->school_year)) {
                $model->school_year = now()->schoolYear();
            }
        });
    }
}
