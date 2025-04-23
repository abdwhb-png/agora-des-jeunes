<?php

namespace App\Traits;

use App\Models\FAQ;
use App\Models\Poll;
use App\Models\JobOffer;
use App\Models\Training;
use App\Models\AgoraSession;
use App\Http\Resources\PollCollection;
use App\Http\Resources\AgoraSessionCollection;
use App\Models\Project;

trait GetRecordsTrait
{
    use FilterTrait;
}
