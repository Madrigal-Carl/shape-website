<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guardian extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone_number',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
