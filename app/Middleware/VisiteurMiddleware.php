<?php

namespace App\Middleware;


class VisiteurMiddleware
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function __invoke($request, $response, $next)
    {
        /*
         *  si l'utilisateur n'est pas connecter
         *  on ne pas donner l'access au certient 'root/Pages'
         */
        if($this->container->auth->isConnected()){
            return $response->withRedirect($this->container->router->pathFor('home'));
        }
        $response = $next($request, $response);
        return $response;

    }
}