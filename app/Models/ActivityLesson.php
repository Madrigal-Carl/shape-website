<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_lessonable_id',
        'activity_lessonable_type',
        'score',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function activityLessonable()
    {
        return $this->morphTo();
    }

    public function studentActivities()
    {
        return $this->hasMany(StudentActivity::class);
    }
}
