<?php

use App\Infrastucture\FileStorage\FileStorage;
use App\Infrastucture\Queue\MessageQueueService;
use App\Register\PublisherValidatorsRegister;
use App\Validator\Publisher\FoulEventValidator;
use App\Validator\Publisher\GoalEventValidator;
use Predis\Client as RedisClient;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Routing\RouteCollection;

return [
    'event_storage_path' => __DIR__ . '/../storage/events.txt',
    'statistics_storage_path' => __DIR__ . '/../storage/statistics.txt',
    'queue_storage_path' => __DIR__ . '/../storage/queue',
    'queue_name' => 'event_queue',
    'redis_config' => function (ContainerInterface $c) {
        return  require __DIR__ . '/redis.config.php';
    },

    FileStorage::class => DI\create()
        ->constructor(DI\get('event_storage_path')),
    RouteCollection::class => function (ContainerInterface $c) {
        return require __DIR__ . '/router.config.php';
    },
    MessageQueueService::class => DI\create()
        ->constructor(DI\get('queue_storage_path'), DI\get('queue_name')),
    Application::class => DI\create(),
    PublisherValidatorsRegister::class => DI\create()
        ->constructor([
            FoulEventValidator::TYPE->value => DI\get(FoulEventValidator::class),
            GoalEventValidator::TYPE->value => DI\get(GoalEventValidator::class),
        ]),
    RedisClient::class => DI\create()->constructor(DI\get('redis_config')),
];
