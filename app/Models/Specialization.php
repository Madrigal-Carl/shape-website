<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specialization extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon'];

    public function instructors()
    {
        return $this->morphedByMany(Instructor::class, 'specializable');
    }

    public function curriculums()
    {
        return $this->morphedByMany(Curriculum::class, 'specializable');
    }

    public function gameActivities()
    {
        return $this->morphedByMany(GameActivity::class, 'specializable');
    }
}
