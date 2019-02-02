<?php
/*
**  routes.php contient:
**      {*}   tout les route de notre application
**              
*/

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// route de page d'acuille
$app->get('/','HomeController:index')->setName('Home');