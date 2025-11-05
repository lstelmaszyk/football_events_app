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

            $eventType = $this->keyTransform($event['type']);

            if (!isset($statistics[$matchId][$event['team_id']][$eventType])) {
                $statistics[$matchId][$event['team_id']][$eventType] = 1;
            } else {
                $statistics[$matchId][$event['team_id']][$eventType] += 1;
            }

        }

        return $statistics;
    }

    private function keyTransform(string $eventName): string
    {
        switch (true) {
            case $eventName === 'goal':
                $eventName = 'goals';
                break;
            case $eventName === 'foul':
                $eventName = 'fouls';
                break;
        }

        return $eventName;
    }
}
