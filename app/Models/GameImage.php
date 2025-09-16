<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'game_activity_id',
    ];

    public function gameActivity()
    {
        return $this->belongsTo(GameActivity::class);
    }
}
