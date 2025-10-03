<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'todo_id',
        'name',
        'path',
        'description',
    ];

    public function specializations()
    {
        return $this->morphToMany(Specialization::class, 'specializable');
    }

    public function gameActivityLessons()
    {
        return $this->hasMany(GameActivityLesson::class);
    }

    public function todo()
    {
        return $this->belongsTo(Todo::class);
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
