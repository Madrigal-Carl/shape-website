<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'instructor_id',
        'image_src',
        'first_name',
        'middle_name',
        'last_name',
        'sex',
        'birth_date',
        'status',
    ];

    public function account()
    {
        return $this->morphOne(Account::class, 'accountable');
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'owner');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function guardian()
    {
        return $this->hasOne(Guardian::class);
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class)->withTimestamps();
    }
}
