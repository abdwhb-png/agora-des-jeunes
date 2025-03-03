<?php

namespace App\Traits;

use App\Models\FAQ;
use App\Models\Poll;
use App\Models\JobOffer;
use App\Models\Training;
use App\Models\AgoraSession;
use App\Http\Resources\PollCollection;
use App\Http\Resources\AgoraSessionCollection;

trait GetRecordsTrait
{
    use FilterTrait;

    public static function paginatedAgoraSessions(): array
    {
        $filterName = 'agora_sessions';
        $search = self::getFilter($filterName, 'search');
        $perPage = self::getFilter($filterName, 'per_page', 10);

        $collection = new AgoraSessionCollection(
            AgoraSession::latest()
                ->where('theme', 'like', '%' . $search . '%')
                ->paginate($perPage, pageName: $filterName)
        );

        return [
            'filter_name' => $filterName,
            'list' => $collection->toArray(request())
        ];
    }

    public static function paginatedPolls(?int $perPage = 10): array
    {
        $filterName = 'polls';
        $search = self::getFilter($filterName, 'search');
        $perPage = self::getFilter($filterName, 'per_page', $perPage);

        $collection = new PollCollection(
            Poll::latest()
                ->where('title', 'like', '%' . $search . '%')
                ->paginate($perPage, pageName: $filterName)
        );

        return [
            'filter_name' => $filterName,
            'list' => $collection->toArray(request())
        ];
    }

    public function paginatedFaqs(?int $perPage = 20, bool $isActive = true): array
    {
        $filterName = 'faqs';
        $search = self::getFilter($filterName, 'search');
        $perPage = self::getFilter($filterName, 'per_page', $perPage);

        return [
            'filter_name' => $filterName,
            'list' => FAQ::orderBy('category')
                ->where('is_active', $isActive)
                ->where('question', 'like', '%' . $search . '%')
                ->orWhere('category', 'like', '%' . $search . '%')
                ->paginate($perPage, pageName: $filterName)
        ];
    }

    public function paginatedJobOffers(?int $perPage = 20): array
    {
        $filterName = 'job_offers';
        $search = self::getFilter($filterName, 'search');
        $perPage = self::getFilter($filterName, 'per_page', $perPage);

        return [
            'filter_name' => $filterName,
            'list' => JobOffer::where('title', 'like', '%' . $search . '%')->latest()
                ->paginate($perPage, pageName: $filterName)
        ];
    }

    public function paginatedTrainings(?int $perPage = 20): array
    {
        $filterName = 'trainings';
        $search = self::getFilter($filterName, 'search');
        $perPage = self::getFilter($filterName, 'per_page', $perPage);

        return [
            'filter_name' => $filterName,
            'list' => Training::where('title', 'like', '%' . $search . '%')->latest()
                ->paginate($perPage, pageName: $filterName)
        ];
    }
}
