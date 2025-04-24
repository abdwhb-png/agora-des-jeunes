<?php

namespace App\Traits;

use App\Models\User;
use App\Models\PollVote;

trait StatsTrait
{
    static public function getUserGrowthChart(string $start, string $end): array
    {
        $days = ceil((strtotime($end) - strtotime($start)) / (60 * 60 * 24));
        $labels = [];
        $data = [];

        for ($i = 0; $i < $days; $i++) {
            $date = date('Y-m-d', strtotime($start . ' +' . $i . ' days'));
            $labels[] = $date;
            $data[] = User::whereDate('created_at', $date)->count();
        }

        return [
            'labels' => $labels,
            'datasets' => [[
                'label' => 'Nouveaux utilisateurs',
                'data' => $data,
                'backgroundColor' => '#4F46E5',
                'borderColor' => '#4F46E5',
                'borderWidth' => 2
            ]]
        ];
    }

    static public function getPollVotesChart(string $start, string $end): array
    {
        $days = ceil((strtotime($end) - strtotime($start)) / (60 * 60 * 24));
        $labels = [];
        $data = [];

        for ($i = 0; $i < $days; $i++) {
            $date = date('Y-m-d', strtotime($start . ' +' . $i . ' days'));
            $labels[] = $date;
            $data[] = PollVote::whereDate('created_at', $date)->count();
        }

        return [
            'labels' => $labels,
            'datasets' => [[
                'label' => 'Votes par jour',
                'data' => $data,
                'backgroundColor' => '#10B981',
                'borderColor' => '#10B981',
                'borderWidth' => 2
            ]]
        ];
    }

    static public function activityStats(): array
    {
        return [
            'totalActivities' => [
                'value' => 0,
                'label' => 'Total Activities',
                'change' => 0,
                'trend' => 'neutral'
            ],
            'completionRate' => [
                'value' => 0,
                'label' => 'Completion Rate',
                'change' => 0,
                'trend' => 'neutral'
            ],
            'avgDuration' => [
                'value' => 0,
                'label' => 'Average Duration',
                'change' => 0,
                'trend' => 'neutral'
            ],
            'chartData' => [
                'labels' => [],
                'datasets' => []
            ]
        ];
    }

    static public function careerStats(): array
    {
        return [
            'jobPlacements' => [
                'value' => 0,
                'label' => 'Job Placements',
                'change' => 0,
                'trend' => 'neutral'
            ],
            'trainingCompleted' => [
                'value' => 0,
                'label' => 'Trainings Completed',
                'change' => 0,
                'trend' => 'neutral'
            ],
            'certifications' => [
                'value' => 0,
                'label' => 'Certifications',
                'change' => 0,
                'trend' => 'neutral'
            ],
            'chartData' => [
                'labels' => [],
                'datasets' => []
            ]
        ];
    }
}
