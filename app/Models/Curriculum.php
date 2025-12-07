<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Curriculum extends Model
{
    use HasFactory;
    protected $fillable = [
        'instructor_id',
        'grade_level_id',
        'name',
        'description',
        'status',
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function specializations()
    {
        return $this->morphToMany(Specialization::class, 'specializable');
    }

    public function curriculumSubjects()
    {
        return $this->hasMany(CurriculumSubject::class);
    }

    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }

    public function legends()
    {
        return $this->hasMany(CurriculumLegend::class);
    }
}
