<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instructor extends Model
{
    use HasFactory;
    protected $fillable = [
        'license_number',
        'image_src',
        'first_name',
        'middle_name',
        'last_name',
        'sex',
        'birth_date',
        'specialization',
        'status',
    ];

    protected $casts = [
        'specialization' => 'array',
    ];

    public function account()
    {
        return $this->morphOne(Account::class, 'accountable');
    }

    public function curriculums()
    {
        return $this->hasMany(Curriculum::class);
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'accountable');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
