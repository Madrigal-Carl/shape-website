<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentQuiz extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'quiz_id',
        'score',
    ];

    public function logs()
    {
        return $this->morphMany(Log::class, 'loggable');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // public function latestLogForStudent($studentId)
    // {
    //     return $this->logs()
    //         ->where('student_id', $studentId)
    //         ->orderByDesc('attempt_number')
    //         ->first();
    // }
}
