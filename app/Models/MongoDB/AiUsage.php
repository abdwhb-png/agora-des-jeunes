<?php

namespace App\Models\MongoDB;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class AiUsage extends Model
{
    use SoftDeletes;

    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'mongodb';

    protected $fillable = [
        'user_id',
        'ai',
        'input_text',
        'output_text',
        'tokens_used',
        'metadata',
    ];
}
