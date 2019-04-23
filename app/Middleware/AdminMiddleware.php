<?php

namespace App\Middleware;

class AdminMiddleware
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function __invoke($request, $response, $next)
    {
        /*
         *  Si l'admin n'est pas connecter
         *  en le rediriqer vers la page de connection
         *  sinon , vers la page d'acuille
        */
        if ( $this->container->auth->isAdminConnected() ) {
            return $response->withRedirect($this->container->router->pathFor('dashboard'));
        }
        $response = $next($request , $response);
        return $response;

    }
}
