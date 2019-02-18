<?php
/*
**  dependencys.php contient :
**      {1}   illuminate/databse "ORM" configuration 
**      {2}   ajoute/config de moteur d'affichag des vue 'php-view'
**      {3}   config de page 404 'page d'ereur'
**      {4}   l'ajout des controller dans le $container
*/

// {1}
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function($container) use ($capsule){
    return $capsule;
};

// {2}
$container['view'] = function ($container) {
    $viewEngine = new \Slim\Views\PhpRenderer('./app/Views' , [
        'baseUrl' => $container['request']->getUri()
    ]);
    $viewEngine->addAttribute("router",$container->router);
    return $viewEngine;
};

// {3}
$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $container['view']->render($response->withStatus(404), '404.php', [] );
    };
};  

// {4}
$container['HomeController'] = function($container){
    return new \App\Controllers\HomeController($container);
};

$container['AuthController'] = function($container){
    return new \App\Controllers\AuthController($container);
};















