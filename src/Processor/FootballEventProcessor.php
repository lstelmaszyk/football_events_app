<?php

namespace App\Processor;

use App\Infrastucture\Cache\EventStorageService;
//use App\StatisticsManager;

class FootballEventProcessor
{
    public function __construct(
//        private readonly StatisticsManager $statisticsManager,
        private readonly EventStorageService $eventStorageService,
    ) {}

    public function process(mixed $data): void
    {
        $this->eventStorageService->saveMatchEvent(
            $data['match_id'],
            json_encode($data)
        );
    }
}
