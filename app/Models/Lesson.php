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

    // public function student()
    // {
    //     return $this->lessonSubject->student();
    // }

    // public function studentCount()
    // {
    //     return $this->lessonSubject->curriculumSubject->students()->count();
    // }
}
