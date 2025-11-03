<?php

namespace App\Controllers;

use App\PublisherEventHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

readonly class EventController
{
    public function __construct(
        private PublisherEventHandler $eventHandler,
    ) {}
    public function createEvent(Request $request): Response
    {
        $data = $request->getPayload()->all();

        try {
            // @todo: add basic validators
            if ($data['type'] === 'foul') {
                if (!isset($data['match_id']) || !isset($data['team_id'])) {
                    throw new \InvalidArgumentException('match_id and team_id are required for foul events');
                }
            }

            $result = $this->eventHandler->handleEvent($data);

            return new Response(json_encode($result), 201, ['Content-Type' => 'application/json']);
        } catch (Exception $e) {
            return new Response(json_encode(['error' => $e->getMessage()]), 400, ['Content-Type' => 'application/json']);
        }
    }
}
