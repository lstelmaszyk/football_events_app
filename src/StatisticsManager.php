<?php

namespace App;

use App\Infrastucture\Cache\EventStorageService;

class StatisticsManager
{
    public function __construct(private readonly EventStorageService $eventStorageService) {}

    public function getTeamStatistics(string $matchId, string $teamId): array
    {
        $stats = $this->getStatistics($matchId);
        return $stats[$matchId][$teamId] ?? [];
    }
    
    public function getMatchStatistics(string $matchId): array
    {
        $stats = $this->getStatistics($matchId);
        return $stats[$matchId] ?? [];
    }
    
    private function getStatistics(string $matchId): array
    {
        return $this->prepareStatistics($matchId, $this->eventStorageService->getAllMatchEvents($matchId));
    }

    private function prepareStatistics(string $matchId, array $events): array
    {
        $statistics = [
            $matchId => [],
        ];

        foreach($events as $key => $event) {
            $event = json_decode($event, true);

            if (!isset($statistics[$matchId][$event['team_id']])) {
                $statistics[$matchId][$event['team_id']] = [];
            }

            if (!isset($statistics[$matchId][$event['team_id']][$event['type']])) {
                $statistics[$matchId][$event['team_id']][$event['type']] = 1;
            } else {
                $statistics[$matchId][$event['team_id']][$event['type']] += 1;
            }

        }

        return $statistics;
    }
}
