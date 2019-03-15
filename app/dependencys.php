<?php
/*
 **  dependencys.php contient :
 **      {1}   illuminate/databse "ORM" configuration
 **      {2}   ajoute/config de moteur d'affichag des vue 'twig'
 **      {3}   config de page 404 'page d'ereur'
 **      {4}   l'ajout des controller dans le $container
 */

//---------------------------ILLUMINATE DATABASE----------------------------------
// {1}
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};

//---------------------------FLASH MESSAGES----------------------------------------
$container['flash'] = function () {
    return new \Slim\Flash\Messages;
};

//------------------------------AUTH CLASS-----------------------------------------
$container['auth'] = function () {
    return new \App\Authentification\Auth;
};

//------------------------------MAILER CLASS---------------------------------------
$container['mailer'] = function () {
    return new \App\Email\Emailer();
};


//-------------------------------TWIG VIEWS---------------------------------------
// {2}
$container['view'] = function ($container) {
    $path = "app" . DIRECTORY_SEPARATOR . "Views";
    $view = new \Slim\Views\Twig($path);
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));
    $view->getEnvironment()->addGlobal('lang', $container->language);
    $view->getEnvironment()->addGlobal('flash', $container->flash);
    $view->getEnvironment()->addGlobal('auth', [
        'connected' => $container->auth->isConnected(),
        'user' => $container->auth->user(),
    ]);

    return $view;
};

//----------------------------404 ERROR PAGE---------------------------------------
// {3}
$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $container['view']->render($response->withStatus(404), '404.twig', []);
    };
};

//----------------------------VALIDATOR CLASS---------------------------------------
$container['validator'] = function ($container) {
    return new \App\Validation\Validator($container->flash);
};

//-----------------------------HOME CONTROLLER--------------------------------------
// {4}
$container['HomeController'] = function ($container) {
    return new \App\Controllers\HomeController($container);
};

//-----------------------------AUTHENTICATING CONTROLLER-----------------------------
$container['AuthController'] = function ($container) {
    return new \App\Controllers\AuthController($container);
};
