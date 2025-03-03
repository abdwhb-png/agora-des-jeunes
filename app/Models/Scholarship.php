<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scholarship extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'provider',
        'country',
        'eligibility',
        'deadline',
        'application_link',
    ];
}