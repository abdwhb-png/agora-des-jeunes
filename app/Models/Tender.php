<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tender extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'organization',
        'deadline',
        'description',
        'application_link',
    ];
}