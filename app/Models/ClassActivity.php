<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function activityLesson()
    {
        return $this->morphOne(ActivityLesson::class, 'activity_lessonable');
    }
}
