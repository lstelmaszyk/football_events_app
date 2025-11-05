<?php

namespace App\Publisher;

use App\Infrastucture\FileStorage\FileStorage;

class PublisherEventHandler
{
    public function __construct(
        private readonly EventDataPublisher    $eventDataPublisher,
        private readonly FileStorage $storage,
    ){}

    public function handleEvent(array $data): array
    {
        $data['timestamp'] = time();
        $this->storage->save($data);
        $this->eventDataPublisher->sendEvent($data);

        return [
            'status' => 'success',
            'message' => 'Event consumed to be processed',
            'event' => $data
        ];
    }
}
