<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'lrn',
        'grade_level',
        'disability_type',
        'support_need',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
