<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
    ];

    protected $casts = [
        'category' => 'array',
    ];

    public function activityLessons()
    {
        return $this->hasMany(ActivityLesson::class);
    }
}
