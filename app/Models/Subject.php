<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function curriculumStudentSubject()
    {
        return $this->hasMany(CurriculumSubject::class);
    }

    // public function lessons()
    // {
    //     return $this->hasManyThrough(
    //         Lesson::class,
    //         LessonSubject::class,
    //         'subject_id',
    //         'curriculum_subject_id',
    //         'id',
    //         'id'
    //     );
    // }
}
