<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain_id',
        'sub_domain_id',
        'todo',
    ];

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    public function subDomain()
    {
        return $this->belongsTo(SubDomain::class);
    }

    public function classActivities()
    {
        return $this->hasMany(ClassActivity::class);
    }

    public function gameActivities()
    {
        return $this->hasMany(GameActivity::class);
    }

    public function subjects()
    {
        return $this->hasManyThrough(
            Subject::class,
            Domain::class,
            'id',
            'id',
            'domain_id',
            'id'
        );
    }

    public function getSubjectIdsAttribute()
    {
        if (!$this->relationLoaded('domain')) {
            $this->load('domain.subjects');
        }

        return $this->domain?->subjects->pluck('id') ?? collect();
    }
}
