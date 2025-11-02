<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DI\ContainerBuilder;
use App\App;

$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/../config/di.config.php');
$container = $builder->build();

$application = $container->get(App::class);
$application->main();
