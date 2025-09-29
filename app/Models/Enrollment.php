<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory;
    protected $fillable = [
        'instructor_id',
        'student_id',
        'grade_level_id',
        'status',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->school_year_id)) {
                $model->school_year_id = now()->schoolYear()?->id;
            }
        });
    }
}
