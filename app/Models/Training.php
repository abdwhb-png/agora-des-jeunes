<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Training extends Model
{
    use LogsActivity;

    protected $table = 'trainings';

    protected $fillable = ['title', 'description', 'location', 'start_date', 'end_date', 'image',];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }
}
