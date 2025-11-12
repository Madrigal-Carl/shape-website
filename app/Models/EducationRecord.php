<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EducationRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_level_id',
        'enrollment_id',
        'school_id',
        'school_year',
        'school_name',
    ];

    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
