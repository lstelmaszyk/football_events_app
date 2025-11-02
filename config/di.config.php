<?php

return [
    'event_storage_path' => __DIR__ . '/../storage/events.txt',
    'statistics_storage_path' => __DIR__ . '/../storage/statistics.txt',

    'App\StatisticsManager' => DI\create()
        ->constructor(DI\get('statistics_storage_path')),
    'App\EventHandler' => DI\create()
        ->constructor(
            DI\get('event_storage_path'),
            DI\get('App\StatisticsManager')
        ),
];
