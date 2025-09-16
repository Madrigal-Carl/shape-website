<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassActivity extends Model
{
    public function activityLesson()
    {
        return $this->morphOne(ActivityLesson::class, 'activity_lessonable');
    }
}
