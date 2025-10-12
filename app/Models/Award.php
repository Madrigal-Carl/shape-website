<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Award extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'path',
    ];

    public function studentAwards()
    {
        return $this->hasMany(StudentAward::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_awards');
    }
}
