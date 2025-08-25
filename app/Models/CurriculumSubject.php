<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CurriculumSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'curriculum_id',
        'subject_id',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
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
            'curriculum_subject_id',
            'id',
            'id',
            'lesson_id'
        );
    }
}
