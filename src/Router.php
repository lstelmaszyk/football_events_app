<?php

namespace App;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Exception;

class Router
{
    public function __construct(
        private readonly RouteCollection $routes,
        private readonly ContainerInterface $container,
    ) {}

    public function handle(Request $request): Response
    {
        $context = new RequestContext();
        $context->fromRequest($request);

        $matcher = new UrlMatcher($this->routes, $context);

        try {
            $parameters = $matcher->match($request->getPathInfo());

            $controllerClass = $parameters['_controller'][0];
            $controllerMethod = $parameters['_controller'][1];

            $controllerInstance = $this->container->get($controllerClass);

            $response = $controllerInstance->$controllerMethod($request);
        } catch (Exception $exception) {
            $response = new Response('Not found or something goes wrong', 404);
        }

        return $response;
    }
}
