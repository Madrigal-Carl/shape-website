<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'activity_lesson_id',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function activityLesson()
    {
        return $this->belongsTo(ActivityLesson::class);
    }
}
