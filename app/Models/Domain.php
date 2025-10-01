<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Domain extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function subDomains()
    {
        return $this->hasMany(SubDomain::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
