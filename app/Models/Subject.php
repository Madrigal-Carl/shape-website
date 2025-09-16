<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'icon',
    ];

    public function curriculumSubjects()
    {
        return $this->hasMany(CurriculumSubject::class);
    }

    public function gameActivities()
    {
        return $this->belongsToMany(GameActivity::class, 'activity_subject');
    }
}
