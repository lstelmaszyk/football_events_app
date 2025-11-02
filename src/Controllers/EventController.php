<?php

namespace App\Controllers;

use App\EventHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

readonly class EventController
{
    public function __construct(
        private EventHandler $eventHandler,
    ) {}
    public function createEvent(Request $request): Response
    {
        $data = $request->getPayload()->all();

        try {
            $result = $this->eventHandler->handleEvent($data);

            return new Response(json_encode($result), 201, ['Content-Type' => 'application/json']);
        } catch (Exception $e) {
            return new Response(json_encode(['error' => $e->getMessage()]), 400, ['Content-Type' => 'application/json']);
        }
    }
}
