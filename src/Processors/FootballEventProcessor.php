<?php

namespace App\Processors;

use App\StatisticsManager;

class FootballEventProcessor
{
    public function __construct(private readonly StatisticsManager $statisticsManager) {}

    public function process(mixed $data): void
    {
        $this->statisticsManager->updateTeamStatistics(
            $data['match_id'],
            $data['team_id'],
            'fouls'
        );
    }
}
