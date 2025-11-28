<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'client',
        'image',
        'link',
        'completed_date',
        'featured',
        'order',
    ];

    protected $casts = [
        'completed_date' => 'date',
        'featured' => 'boolean',
        'order' => 'integer',
    ];
}
