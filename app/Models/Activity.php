<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'description',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function specializations()
    {
        return $this->morphToMany(Specialization::class, 'specializable');
    }

    public function activityLesson()
    {
        return $this->hasOne(ActivityLesson::class);
    }

    public function latestLogForStudent($studentId)
    {
        if (!$this->activityLesson) return null;

        return $this->activityLesson->logs()
            ->where('student_id', $studentId)
            ->latest('attempt_number')
            ->first();
    }

    public function activityImages()
    {
        return $this->hasMany(ActivityImage::class);
    }
}
