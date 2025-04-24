<?php

namespace App\Http\Controllers;

use App\Helpers\ConfigHelper;
use App\Models\Poll;
use App\Models\PollVote;
use App\Http\Controllers\Base\BaseController;
use App\Models\AppFeature;
use App\Models\Arrondissement;
use App\Models\Commune;
use App\Models\Departement;
use App\Models\MongoDB\AiUsage as MongoDBAiUsage;
use App\Models\AiUsage;
use App\Models\User;
use App\Models\UserInfo;
use App\Traits\StatsTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApiController extends BaseController
{
    use StatsTrait;

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|' . implode('|', ConfigHelper::imageRules()),
        ]);

        $path = $this->storeImage($request);

        return response()->json(['url' => Storage::url($path)]);
    }

    public function getDepartements(): JsonResponse
    {
        return response()->json(
            [
                'departements' => Departement::with('communes.arrondissements')->get(),
                'communes' => Commune::with('arrondissements')->get(),
                'arrondissements' => Arrondissement::all(),
            ]
        );
    }

    public function getFeatures(): JsonResponse
    {
        return response()->json(
            [
                'app_features' => AppFeature::all(),
            ]
        );
    }

    public function aiUsage(Request $request)
    {
        MongoDBAiUsage::create([
            'user_id' => $request->user()->id,
            'ai' => $request->ai,
            'input_text' => $request->input_text,
            'output_text' => $request->output_text,
            'tokens_used' => $request->tokens_used,
            'metadata' => $request->metadata
        ]);
        return response()->json(['success' => true], 204);
    }

    public function getStats(Request $request): JsonResponse
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start'
        ]);

        $start = $request->input('start');
        $end = $request->input('end');
        $previousStart = date('Y-m-d', strtotime($start . ' -' . abs(strtotime($end) - strtotime($start)) . ' seconds'));

        // User Stats
        $currentUsers = User::whereBetween('created_at', [$start, $end])->count();
        $previousUsers = User::whereBetween('created_at', [$previousStart, $start])->count();
        $activeUsers = User::where('status', true)->count();
        $totalUsers = User::count();

        $userStats = [
            'totalUsers' => [
                'value' => $totalUsers,
                'label' => 'Utilisateurs au total',
                'change' => 0,
                'trend' => 'neutral'
            ],
            'activeUsers' => [
                'value' => $activeUsers,
                'label' => 'Utilisateurs actifs',
                'change' => $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 0,
                'trend' => 'neutral'
            ],
            'newUsers' => [
                'value' => $currentUsers,
                'label' => 'Nouveaux utilisateurs',
                'change' => $previousUsers > 0 ? round((($currentUsers - $previousUsers) / $previousUsers) * 100) : 0,
                'trend' => $currentUsers > $previousUsers ? 'up' : ($currentUsers < $previousUsers ? 'down' : 'neutral')
            ],
            'chartData' => $this->getUserGrowthChart($start, $end)
        ];

        // Geographic Stats
        $quartiers = UserInfo::select('quartier')
            ->whereNotNull('quartier')
            ->groupBy('quartier')
            ->get()
            ->map(function ($item) {
                $count = UserInfo::where('quartier', $item->quartier)->count();
                return [
                    'value' => $count,
                    'label' => $item->quartier,
                    'trend' => 'neutral'
                ];
            });

        $cities = UserInfo::select('ville')
            ->whereNotNull('ville')
            ->groupBy('ville')
            ->get()
            ->map(function ($item) {
                $count = UserInfo::where('ville', $item->ville)->count();
                return [
                    'value' => $count,
                    'label' => $item->ville,
                    'trend' => 'neutral'
                ];
            });

        $arrondissements = UserInfo::select('arrondissement')
            ->whereNotNull('arrondissement')
            ->groupBy('arrondissement')
            ->get()
            ->map(function ($item) {
                $count = UserInfo::where('arrondissement', $item->arrondissement)->count();
                return [
                    'value' => $count,
                    'label' => $item->arrondissement,
                    'trend' => 'neutral'
                ];
            });

        $geoStats = [
            'quartiers' => $quartiers,
            'cities' => $cities,
            'arrondissements' => $arrondissements,
            'chartDatas' => [
                'quartiers' => [
                    'labels' => $quartiers->pluck('label'),
                    'datasets' => [[
                        'label' => 'Utilisateurs dans ce quartier',
                        'data' => $quartiers->pluck('value'),
                        'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                        'borderColor' => '#3B82F6',
                        'borderWidth' => 2,
                    ]]
                ],
                'cities' => [
                    'labels' => $cities->pluck('label'),
                    'datasets' => [[
                        'label' => 'Utilisateurs dans la ville',
                        'data' => $cities->pluck('value'),
                        'backgroundColor' => 'rgba(99, 102, 241, 0.1)',
                        'borderColor' => '#6366F1',
                        'borderWidth' => 2,
                    ]]
                ],
                'arrondissements' => [
                    'labels' => $quartiers->pluck('label'),
                    'datasets' => [[
                        'label' => 'Utilisateurs dans ce quartier',
                        'data' => $quartiers->pluck('value'),
                        'backgroundColor' => 'rgba(59, 130, 206, 0.1)',
                        'borderColor' => '#3BF6',
                        'borderWidth' => 2,
                    ]]
                ]
            ]
        ];

        // Poll Stats
        $currentPolls = Poll::whereBetween('created_at', [$start, $end])->count();
        $previousPolls = Poll::whereBetween('created_at', [$previousStart, $start])->count();
        $activePolls = Poll::notExpired()->count();
        $totalPolls = Poll::count();
        $totalVotes = PollVote::count();
        $previousVotes = PollVote::whereBetween('created_at', [$previousStart, $start])->count();
        $currentVotes = PollVote::whereBetween('created_at', [$start, $end])->count();

        $pollStats = [
            'totalPolls' => [
                'value' => $totalPolls,
                'label' => 'Sondages au total',
                'change' => $previousPolls > 0 ? round((($currentPolls - $previousPolls) / $previousPolls) * 100) : 0,
                'trend' => $currentPolls > $previousPolls ? 'up' : ($currentPolls < $previousPolls ? 'down' : 'neutral')
            ],
            'activePolls' => [
                'value' => $activePolls,
                'label' => 'Sondages actifs',
                'change' => $totalPolls > 0 ? round(($activePolls / $totalPolls) * 100) : 0,
                'trend' => $activePolls > 0 ? 'up' : 'neutral'
            ],
            'totalVotes' => [
                'value' => $totalVotes,
                'label' => 'Votes au total',
                'change' => $previousVotes > 0 ? round((($currentVotes - $previousVotes) / $previousVotes) * 100) : 0,
                'trend' => $currentVotes > $previousVotes ? 'up' : ($currentVotes < $previousVotes ? 'down' : 'neutral')
            ],
            'chartData' => $this->getPollVotesChart($start, $end)
        ];

        return response()->json([
            'userStats' => $userStats,
            'geographicStats' => $geoStats,
            'pollStats' => $pollStats,
            'activityStats' => $this->activityStats(),
            'careerStats' => $this->careerStats(),
        ]);
    }
}
