<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'item_type',
        'best_time_spent',
        'status',
    ];

    public function item()
    {
        return $this->morphTo();
    }
}
