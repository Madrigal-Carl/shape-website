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
}
