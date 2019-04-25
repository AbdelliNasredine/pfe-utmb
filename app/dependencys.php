<?php
/*
 **  dependencys.php contient :
 **      {1}   illuminate/databse "ORM" configuration
 **      {2}   ajoute/config de moteur d'affichag des vue 'twig'
 **      {3}   config de page 404 'page d'ereur'
 **      {4}   l'ajout des controller dans le $container
 */

use App\Models\Categorie;
//---------------------------ILLUMINATE DATABASE----------------------------------
// {1}
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};
//---------------------------ARCHIVE / DOSSIER DE TELECHARGEMENT-------------------
$container['upload_directory'] = __DIR__ .DIRECTORY_SEPARATOR . '..'. DIRECTORY_SEPARATOR .'uploads';

//---------------------------DOSSIER DE PROFIL IMAGES -----------------------------
$container['profil_imgs_directory'] = __DIR__ .DIRECTORY_SEPARATOR . '..'
                                . DIRECTORY_SEPARATOR .'public' 
                                . DIRECTORY_SEPARATOR .'img'
                                .DIRECTORY_SEPARATOR.'profiles';

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
    $view = new \Slim\Views\Twig($path , [
        'debug' => true
    ]);
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));
    $view->getEnvironment()->addGlobal('lang', $container->language);
    $view->getEnvironment()->addGlobal('flash', $container->flash);
    $view->getEnvironment()->addGlobal('auth', [
        'connected' => $container->auth->isConnected(),
        'user' => $container->auth->user(),
        'admin' => $container->auth->admin(),
    ]);
    $view->getEnvironment()->addGlobal('cat', Categorie::all() );
    $view->addExtension(new \Twig_Extension_Debug());

    return $view;
};
$url_generator = new Twig_SimpleFunction('generateURL', function($url){
    return slugGenerate($url);
});
$rand_cl = new Twig_SimpleFunction('randCl', function(){
    return randomColor();
});
$container->get('view')->getEnvironment()->addFunction($rand_cl);
$container->get('view')->getEnvironment()->addFunction($url_generator);

//----------------------------ERROR HANDLING PAGE'S---------------------------------------
//----------------------------404 ERROR PAGE---------------------------------------
// {3}
unset($app->getContainer()['notFoundHandler']);
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
//-----------------------------ADMIN CONTROLLER-----------------------------
$container['RechercheController'] = function ($container) {
    return new \App\Controllers\RechercheController($container);
};
//-----------------------------CATEGORIES CONTROLLER-----------------------------
$container['CategorieController'] = function ($container) {
    return new \App\Controllers\CategorieController($container);
};

//-----------------------------DOCUMENTS CONTROLLER-----------------------------
$container['DocumentController'] = function ($container) {
    return new \App\Controllers\DocumentController($container);
};
//-----------------------------EVALUATIONS CONTROLLER-----------------------------
$container['EvaluationController'] = function ($container) {
    return new \App\Controllers\EvaluationController($container);
};
//-----------------------------USER CONTROLLER-----------------------------
$container['UserController'] = function ($container) {
    return new \App\Controllers\UserController($container);
};
//-----------------------------ADMIN CONTROLLER-----------------------------
$container['AdminController'] = function ($container) {
    return new \App\Controllers\AdminController($container);
};