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

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
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
