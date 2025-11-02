<?php

namespace App;

use Exception;

class App
{
    public function __construct(
        private readonly EventHandler $eventHandler,
        private readonly StatisticsManager $statisticsManager,
    ) {}

    public function main(): void
    {
        header('Content-Type: application/json');

        // Simple routing
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if ($method === 'POST' && $path === '/event') {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid JSON']);
                exit;
            }

            try {
                $result = $this->eventHandler->handleEvent($data);
                http_response_code(201);
                echo json_encode($result);
            } catch (Exception $e) {
                http_response_code(400);
                echo json_encode(['error' => $e->getMessage()]);
            }
        } elseif ($method === 'GET' && $path === '/statistics') {
            $matchId = $_GET['match_id'] ?? null;
            $teamId = $_GET['team_id'] ?? null;

            try {
                if ($matchId && $teamId) {
                    // Get team statistics for specific match
                    $stats = $this->statisticsManager->getTeamStatistics($matchId, $teamId);
                    echo json_encode([
                        'match_id' => $matchId,
                        'team_id' => $teamId,
                        'statistics' => $stats
                    ]);
                } elseif ($matchId) {
                    // Get all team statistics for specific match
                    $stats = $this->statisticsManager->getMatchStatistics($matchId);
                    echo json_encode([
                        'match_id' => $matchId,
                        'statistics' => $stats
                    ]);
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'match_id is required']);
                }
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['error' => $e->getMessage()]);
            }
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Not found']);
        }
    }
}
