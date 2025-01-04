<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackCalculation extends Model
{
    protected function casts(): array
    {
        return [
            'pack_sizes' => 'json',
            'pack_sizes.*' => 'integer',
            'packs' => 'array',
            'widget_count' => 'integer',
        ];
    }

    protected $fillable = [
        'pack_sizes',
        'widget_count',
        'packs',
    ];
}
