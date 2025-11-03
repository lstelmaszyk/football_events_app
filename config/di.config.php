<?php

use App\FileStorage;
use App\Queue\MessageQueueService;
use App\StatisticsManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Routing\RouteCollection;

return [
    'event_storage_path' => __DIR__ . '/../storage/events.txt',
    'statistics_storage_path' => __DIR__ . '/../storage/statistics.txt',
    'queue_storage_path' => __DIR__ . '/../storage/queue',
    'queue_name' => 'event_queue',

    FileStorage::class => DI\create()
        ->constructor(DI\get('event_storage_path')),
    StatisticsManager::class => DI\create()
        ->constructor(DI\get('statistics_storage_path')),
    RouteCollection::class => function (ContainerInterface $c) {
        return require __DIR__ . '/router.config.php';
    },
    MessageQueueService::class => DI\create()
        ->constructor(DI\get('queue_storage_path'), DI\get('queue_name')),
    Application::class => DI\create(),
];
