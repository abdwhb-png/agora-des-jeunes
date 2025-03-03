<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobOffer extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'title',
        'company',
        'location',
        'description',
        'requirements',
        'salary_range',
        'application_link',
        'image',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }
}
