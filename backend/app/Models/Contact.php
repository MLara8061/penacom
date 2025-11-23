<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'mobile',
        'email',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'whatsapp',
        'facebook',
        'instagram',
        'twitter',
        'linkedin'
    ];
}
