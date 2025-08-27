<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Award extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description'
    ];

    public function studentAwards()
    {
        return $this->hasMany(StudentAward::class);
    }
}
