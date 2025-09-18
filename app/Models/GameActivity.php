<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'description',
    ];

    public function specializations()
    {
        return $this->morphToMany(Specialization::class, 'specializable');
    }

    public function activityLesson()
    {
        return $this->morphMany(ActivityLesson::class, 'activity_lessonable');
    }

    public function curriculumSubject()
    {
        return $this->belongsTo(CurriculumSubject::class);
    }

    public function gameImages()
    {
        return $this->hasMany(GameImage::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'game_activity_subject');
    }
}
