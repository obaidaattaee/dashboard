<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * define plan durations
     */
    const DURATIONS = [
        [
            'display_name' => 'montly',
            'name' => 'month',
        ], [
            'display_name' => 'annual',
            'name' => 'year',
        ],
    ];

    /**
     * define the table scope filter
     */
    public function scopeTableFilter($query)
    {
        return $query->when(request()->input('name', false), function ($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        });
    }

    public function getDurationNameAttribute()
    {
        $duration = collect(self::DURATIONS)->where('name' , $this->getAttribute('duration'))->first();
        if ($duration) {
            return $duration['display_name'];
        }
        return self::DURATIONS[0]['display_name'];
    }
}
