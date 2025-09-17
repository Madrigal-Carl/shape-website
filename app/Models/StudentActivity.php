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
    ];

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function activityLesson()
    {
        return $this->belongsTo(ActivityLesson::class);
    }

    // public function latestLogForStudent($studentId)
    // {
    //     if (!$this->activityLesson) return null;

    //     return $this->activityLesson->logs()
    //         ->where('student_id', $studentId)
    //         ->latest('attempt_number')
    //         ->first();
    // }
}
