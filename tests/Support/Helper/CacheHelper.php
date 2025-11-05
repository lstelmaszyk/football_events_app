<?php

declare(strict_types=1);

namespace Tests\Support\Helper;

use Predis\Client;

class CacheHelper extends \Codeception\Module
{
    private Client $redisClient;

    public function initRedisConnection(array $redisConfig): void
    {
        $this->redisClient = new Client($redisConfig);
    }

    public function flushAll(): void {
        $this->redisClient->flushall();
        // wait (easy hacky way) for redis to process the flushall command
        usleep(500000);
    }
}
