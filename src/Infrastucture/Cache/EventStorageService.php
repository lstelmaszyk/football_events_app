<?php

namespace App\Infrastucture\Cache;

use Predis\Client as RedisClient;

class EventStorageService
{
    public function __construct(private RedisClient $redisClient) {}

    public function saveMatchEvent(string $matchId, string $event): void
    {
        $this->redisClient->rpush($matchId, [$event]);
    }

    /**
     * @param string $matchId
     * @return string[]
     */
    public function getAllMatchEvents(string $matchId): array
    {
        return $this->redisClient->lrange($matchId, 0, -1);
    }

    public function getEvents(string $matchId): array {
        return [];
    }
}
