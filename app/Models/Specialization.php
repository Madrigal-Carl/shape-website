<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specialization extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function instructors()
    {
        return $this->morphedByMany(Instructor::class, 'specializable');
    }

    public function curriculums()
    {
        return $this->morphedByMany(Curriculum::class, 'specializable');
    }

    public function activities()
    {
        return $this->morphedByMany(Activity::class, 'specializable');
    }
}
