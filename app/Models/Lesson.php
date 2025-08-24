<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;
    protected $fillable = [
        'lesson_subject_id',
        'title',
        'description',
    ];

    public function student()
    {
        return $this->lessonSubject->student();
    }

    public function studentCount()
    {
        return $this->lessonSubject->curriculumSubject->students()->count();
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function lessonSubject()
    {
        return $this->belongsTo(LessonSubject::class);
    }

    public function activityLessons()
    {
        return $this->hasMany(ActivityLesson::class);
    }

    public function lessonQuizzes()
    {
        return $this->hasMany(LessonQuiz::class);
    }
}
