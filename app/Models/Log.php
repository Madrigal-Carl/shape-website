<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'item_type',
        'attempt',
        'success',
    ];

    public function item()
    {
        return $this->morphTo();
    }
}
