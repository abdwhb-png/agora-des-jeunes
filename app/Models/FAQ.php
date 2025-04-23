<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FAQ extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'answer', 'category', 'is_active'];

    public function scopeSearch(Builder $query, $search)
    {
        return $query->where('question', 'like', '%' . $search . '%')
            ->orWhere('category', 'like', '%' . $search . '%');
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        return $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->search($search);
        })->when($filters['category'] ?? null, function ($query, $category) {
            $query->where('category', $category);
        })->when($filters['is_active'] ?? null, function ($query, $isActive) {
            $query->where('is_active', (bool) $isActive);
        })->when($filters['sort'] ?? null, function ($query, $sort) {
            $query->orderBy($sort['field'], $sort['order']);
        });
    }
}
