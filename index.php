<?php
/*
**  Documentation génere par : A.Nasredine
**  index.php :
**      {*}   gére tout les 'Request/Response' de l'application
**      {2}   getion des 'Middleware'    
*/

session_start();

require './vendor/autoload.php';
require './app/configs.php';

//creation d'application `object => $app type Slim\App`
$app = new \Slim\App(
    ['settings' => $config]
);

$container = $app->getContainer();

/*
**  {2}
**  les variables: 
**      -   $available_languages
**      -   $default_language
**  sont importer de fichier 'config.php' 
*/
$app->add( new \App\Middleware\LanguageMiddleware($available_languages, $default_language, $container) );

require './app/functions.php';
require './app/dependencys.php';
require './app/routes.php';

// lancement d'application
$app->run();

