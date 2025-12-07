<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CurriculumLegend extends Model
{
    use HasFactory;

    protected $fillable = [
        'curriculum_id',
        'legend_key',
        'legend_label',
        'percentage',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
