<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model {
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'service',
        'message',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
