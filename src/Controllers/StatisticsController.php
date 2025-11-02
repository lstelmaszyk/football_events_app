<?php

namespace App\Controllers;

use App\StatisticsManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

readonly class StatisticsController
{
    public function __construct(
        private StatisticsManager $statisticsManager,
    ) {}

    public function getStatistics(Request $request): Response
    {
        $get = $request->query->all();

        $matchId = $get['match_id'] ?? null;
        $teamId = $get['team_id'] ?? null;

        try {
            if ($matchId && $teamId) {
                // Get team statistics for specific match
                $stats = $this->statisticsManager->getTeamStatistics($matchId, $teamId);

                return new Response(json_encode([
                    'match_id' => $matchId,
                    'team_id' => $teamId,
                    'statistics' => $stats
                ]), 200, ['Content-Type' => 'application/json']);
            } elseif ($matchId) {
                // Get all team statistics for specific match
                $stats = $this->statisticsManager->getMatchStatistics($matchId);

                return new Response(json_encode([
                    'match_id' => $matchId,
                    'statistics' => $stats
                ]), 200, ['Content-Type' => 'application/json']);
            } else {
                return new Response(json_encode(['error' => 'match_id is required']), 400, ['Content-Type' => 'application/json']);
            }
        } catch (Exception $e) {
            return new Response(json_encode(['error' => $e->getMessage()]), 500, ['Content-Type' => 'application/json']);
        }
    }
}
