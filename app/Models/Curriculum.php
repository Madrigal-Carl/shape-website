<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Curriculum extends Model
{
    use HasFactory;
    protected $fillable = [
        'instructor_id',
        'name',
        'grade_level',
        'specialization',
        'description',
        'status',
    ];

    protected $casts = [
        'specialization' => 'array',
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function curriculumSubjects()
    {
        return $this->hasMany(CurriculumSubject::class);
    }
}
