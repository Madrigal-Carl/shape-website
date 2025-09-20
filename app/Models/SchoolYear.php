<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'first_quarter_start',
        'first_quarter_end',
        'second_quarter_start',
        'second_quarter_end',
        'third_quarter_start',
        'third_quarter_end',
        'fourth_quarter_start',
        'fourth_quarter_end',
    ];

    public function isCurrent()
    {
        return now()->between($this->first_quarter_start, $this->fourth_quarter_end);
    }

    public function hasEnded()
    {
        return now()->greaterThan(Carbon::parse($this->fourth_quarter_end));
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $startYear = Carbon::parse($model->first_quarter_start)->year;
            $endYear   = Carbon::parse($model->fourth_quarter_end)->year;

            $model->name = $startYear . '-' . $endYear;
        });

        static::updating(function ($model) {
            $startYear = Carbon::parse($model->first_quarter_start)->year;
            $endYear   = Carbon::parse($model->fourth_quarter_end)->year;

            $model->name = $startYear . '-' . $endYear;
        });
    }
}
