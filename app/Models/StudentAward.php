<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentAward extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'award_id'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function award()
    {
        return $this->belongsTo(Award::class);
    }
}
