<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubDomain extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain_id',
        'name',
    ];

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }
}
