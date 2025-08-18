<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'province',
        'municipality',
        'barangay',
        'type',
        'owner_id',
        'owner_type',
    ];

    public function owner()
    {
        return $this->morphTo();
    }
}
