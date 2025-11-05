<?php

namespace App\Publisher;

use App\Infrastucture\Queue\MessageQueueService;

class EventDataPublisher
{
    public function __construct(
        private readonly MessageQueueService $messageQueueService,
    ) {}

    public function sendEvent(array $data): void
    {
        $this->messageQueueService->sendMessage(json_encode($data));
    }
}
