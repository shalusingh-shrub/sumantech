<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name', 'role', 'designation', 'school', 'block', 'district',
        'contribution', 'description', 'image', 'category', 'order',
        'is_featured', 'status',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'status' => 'boolean',
    ];
}
