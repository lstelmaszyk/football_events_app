#!/usr/bin/env php
<?php

require __DIR__.'/../vendor/autoload.php';

use App\Commands\EventConsumerCommand;
use DI\ContainerBuilder;
use Symfony\Component\Console\Application;

$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/../config/di.config.php');
$container = $builder->build();

$application = $container->get(Application::class);

$application->add($container->get(EventConsumerCommand::class));

$application->run();
