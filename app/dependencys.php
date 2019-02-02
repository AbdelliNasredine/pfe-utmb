<?php
/*
**  dependencys.php contient :
**      {1}   ajoute de con PDO dans le $container  
**      {2}   ajoute/config de moteur d'affichag des vue 'php-view'
**      {3}   config de page 404 'page d'ereur'
**      {4}   ajoute des 'Controlles' dans $constainer
*/

// {1}
$container['db'] = function ($container) {
    $db = $container['settings']['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
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
$container['HomeController'] = function($constainer) {
    return new App\Controllers\HomeController($constainer);
};
