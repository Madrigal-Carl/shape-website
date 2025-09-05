<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'grade_level',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->school_year)) {
                $model->school_year = $model->getSchoolYear();
            }
        });
    }

    public function getSchoolYear(): string
    {
        $now = now();
        $year = $now->year;

        return $now->month >= 6
            ? $year . '-' . ($year + 1)
            : ($year - 1) . '-' . $year;
    }
}
