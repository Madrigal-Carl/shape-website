<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GradeLevel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function instructors()
    {
        return $this->belongsToMany(Instructor::class, 'grade_level_instructor');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function curriculums()
    {
        return $this->hasMany(Curriculum::class);
    }
}
