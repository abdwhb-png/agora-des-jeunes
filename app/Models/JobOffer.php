<?php

namespace App\Models;

use App\Traits\ModelWithFile;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobOffer extends Model
{
    use HasFactory, ModelWithFile;
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

    static function booted()
    {
        static::deleting(function ($model) {
            self::onDeleting($model->image);
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

    public function scopeSearch(Builder $query, $search)
    {
        $query->where('title', 'like', '%' . $search . '%')
            ->orWhere('company', 'like', '%' . $search . '%')
            ->orWhere('location', '%' . $search . '%')
            ->orWhere('description', '%' . $search . '%')
            ->orWhere('requirements', '%' . $search . '%')
            ->orWhere('salary_range', '%' . $search . '%')
            ->orWhere('application_link', '%' . $search . '%');
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->search($search);
        })->when($filters['sort'] ?? null, function ($query, $sort) {
            $query->orderBy($sort['field'], $sort['order']);
        });
    }
}
