<?php

namespace App;

use App\Publishers\EventDataPublisher;

class PublisherEventHandler
{
    public function __construct(
        private readonly EventDataPublisher    $eventDataPublisher,
        private readonly FileStorage $storage,
    ){}

    public function handleEvent(array $data): array
    {
        $this->storage->save($data);
        $this->eventDataPublisher->sendEvent($data);

        return [
            'status' => 'success',
            'message' => 'Event consumed to be processed',
            'event' => $data
        ];
    }
}
