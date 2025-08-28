<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentAward extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'award_id',
        'academic_year'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function award()
    {
        return $this->belongsTo(Award::class);
    }

    public function getAcademicYear(): string
    {
        $now = now();
        $year = $now->year;

        if ($now->month >= 6) {
            return $year . '-' . ($year + 1);
        }
        return ($year - 1) . '-' . $year;
    }
}
