<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feed extends Model
{
    use HasFactory;
    protected $fillable = [
        'notifiable_id',
        'notifiable_type',
        'group',
        'title',
        'message',
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }
}
