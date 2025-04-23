<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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

    public function scopeSearch(Builder $query, $search)
    {
        return $query->where('title', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->orWhere('location', '%' . $search . '%');
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        return $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->search($search);
        })->when($filters['start_date'] ?? null, function ($query, $start_date) {
            $query->where('start_date', '>=', $start_date);
        })->when($filters['end_date'] ?? null, function ($query, $end_date) {
            $query->where('end_date', '<=', $end_date);
        })->when($filters['sort'] ?? null, function ($query, $sort) {
            $query->orderBy($sort['field'], $sort['order']);
        });
    }
}
