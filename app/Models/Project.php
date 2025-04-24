<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'type', 'description', 'markdown_content', 'html_content', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sections()
    {
        return $this->hasMany(ProjectSection::class);
    }

    public function recommendedFundings()
    {
        return $this->belongsToMany(Funding::class, 'project_funding_matches');
    }
}
