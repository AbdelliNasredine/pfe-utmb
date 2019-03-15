<?php

namespace App\Middleware;

class AuthMiddleware
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function __invoke($request, $response, $next)
    {
        /*
         *  Si l'utilisateur n'est pas connecter
         *  en le rediriqer vers la page d'inscription
         *  sinon , vers la page d'acuille
        */
        if (!$this->container->auth->isConnected()) {
            $this->container->flash->addMessage('error','Veuillez vous connecter avant de faire cela ! ');
            return $response->withRedirect($this->container->router->pathFor('connection'));
        }
        $response = $next($request , $response);
        return $response;

    }
}