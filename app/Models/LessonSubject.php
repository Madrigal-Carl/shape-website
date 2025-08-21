<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LessonSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'curriculum_subject_id',
        'student_id',
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function curriculumSubject()
    {
        return $this->belongsTo(CurriculumSubject::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
