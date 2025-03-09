<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AiUsage extends Model
{
    use SoftDeletes;

    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'pgsql';

    protected $fillable = [
        'user_id',
        'ai',
        'input_text',
        'output_text',
        'tokens_used',
        'metadata',
    ];
}
