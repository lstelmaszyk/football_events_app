<?php

namespace App;

use Symfony\Component\HttpFoundation\Response;

class App
{
    public function __construct(
        private readonly Router $router,
    ) {}


    public function handle($request): Response
    {
        return $this->router->handle($request);
    }
}
