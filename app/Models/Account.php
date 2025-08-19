<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'username',
        'password',
        'accountable_id',
        'accountable_type',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts()
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function accountable()
    {
        return $this->morphTo();
    }
}
