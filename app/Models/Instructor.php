<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instructor extends Model
{
    use HasFactory;
    protected $fillable = [
        'license_number',
        'path',
        'first_name',
        'middle_name',
        'last_name',
        'sex',
        'birth_date',
        'status',
    ];

    public function getFullNameAttribute()
    {
        $middleInitial = $this->middle_name ? strtoupper(substr($this->middle_name, 0, 1)) . '.' : '';
        return "{$this->first_name} {$middleInitial} {$this->last_name}";
    }

    public function account()
    {
        return $this->morphOne(Account::class, 'accountable');
    }

    public function curriculums()
    {
        return $this->hasMany(Curriculum::class);
    }

    public function specializations()
    {
        return $this->morphToMany(Specialization::class, 'specializable');
    }

    public function gradeLevels()
    {
        return $this->belongsToMany(GradeLevel::class, 'grade_level_instructor');
    }

    public function lessons()
    {
        return Lesson::whereHas('lessonSubjectStudents.curriculumSubject.curriculum', function ($query) {
            $query->where('instructor_id', $this->id);
        });
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'owner');
    }

    public function permanentAddress()
    {
        return $this->morphOne(Address::class, 'owner')->where('type', 'permanent');
    }

    public function currentAddress()
    {
        return $this->morphOne(Address::class, 'owner')->where('type', 'current');
    }

    public function students()
    {
        return $this->belongsToMany(
            Student::class,
            'enrollments',
            'instructor_id',
            'student_id'
        )->distinct()->with('enrollments');
    }

    public function feeds()
    {
        return $this->morphMany(Feed::class, 'notifiable');
    }

    public function eligibleStudents(Curriculum $curriculum)
    {
        return $this->students()
            ->whereHas('enrollments', function ($q) use ($curriculum) {
                $q->where('grade_level_id', $curriculum->grade_level_id);
            })
            ->whereIn('disability_type', $curriculum->specializations->pluck('name'));
    }

    // public function admin()
    // {
    //     return $this->belongsTo(Admin::class);
    // }
}
