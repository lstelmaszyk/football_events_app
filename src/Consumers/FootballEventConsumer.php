<?php

namespace App\Consumers;

use App\Processors\FootballEventProcessor;
use App\Queue\MessageQueueService;

class FootballEventConsumer
{
    public function __construct(
        private readonly MessageQueueService $messageQueueService,
        private readonly FootballEventProcessor $processor,
    ) {}

    /**
     * @return string|null
     *
     * @throws \Exception
     */
    public function consume(): string|null
    {
        $message = $this->messageQueueService->consumeMessage();

        if ($message !== null) {
            try {
                $this->processor->process(json_decode($message->getBody(), true));
                $this->messageQueueService->acknowledgeMessage($message);
            } catch (\Exception $e) {
                $this->messageQueueService->rejectMessage($message);
                throw $e;
            }
        }

        return $message->getBody() ?? null;
    }
}
