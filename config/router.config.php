<?php

use App\Controllers\EventController;
use App\Controllers\StatisticsController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add(
    'event',
    (new Route('/event', ['_controller' => [EventController::class, 'createEvent']]))->setMethods('POST'),
);

$routes->add(
    'statistics',
    (new Route('statistics', ['_controller' => [StatisticsController::class, 'getStatistics']]))->setMethods('GET'),
);

return $routes;
