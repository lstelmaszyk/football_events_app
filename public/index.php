<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\App;
use DI\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;

$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/../config/di.config.php');
$container = $builder->build();

$application = $container->get(App::class);

$request = Request::createFromGlobals();
$response = $application->handle($request);
$response->send();
