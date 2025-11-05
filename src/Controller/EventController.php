<?php

namespace App\Controller;

use App\Publisher\PublisherEventHandler;
use App\Register\PublisherValidatorsRegister;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

readonly class EventController
{
    public function __construct(
        private PublisherEventHandler $eventHandler,
        private PublisherValidatorsRegister $validatorsRegister,
    ) {}
    public function createEvent(Request $request): Response
    {
        try {
            $data = $request->getPayload()->all();

            $this->validatorsRegister->getValidatorByType($data['type'] ?? null)->validate($data);

            $result = $this->eventHandler->handleEvent($data);

            return new Response(json_encode($result), 201, ['Content-Type' => 'application/json']);
        } catch (Exception $e) {
            return new Response(json_encode(['error' => $e->getMessage()]), 400, ['Content-Type' => 'application/json']);
        }
    }
}
