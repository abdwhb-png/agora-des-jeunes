<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CvInfo extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'summery',
        'job_title',
        'experiences',
        'educations',
        'skills',
        'languages',
        'interests',
    ];

    protected function casts(): array
    {
        return [
            'experiences' => 'array',
            'skills' => 'array',
            'educations' => 'array',
            'languages' => 'array',
            'interests' => 'array',
        ];
    }

    public function cv(): BelongsTo
    {
        return $this->belongsTo(CV::class);
    }
}