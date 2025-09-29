<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Account extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
