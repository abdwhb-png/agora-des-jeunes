<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    protected $fillable = [
        'name',
        'email',
        'message',
        'entries',
        'ip_address'
    ];

    protected $casts = [
        'entries' => 'array',
    ];
}
