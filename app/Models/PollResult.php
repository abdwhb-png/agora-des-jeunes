<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollResult extends Model
{
    use HasFactory;

    protected $fillable = ['poll_id', 'poll_option_id', 'votes'];

    // Relation avec l'utilisateur (peut être null)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec le sondage
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }


    // Relation avec l'option choisie
    public function option()
    {
        return $this->belongsTo(PollOption::class);
    }
}
