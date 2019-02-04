<?php
/*
**  routes.php contient:
**      {*}   tout les route de notre application
**      {?} 'setName()' : change le nom de route var un autre nome 
**                          pour simplifie l'acces aprés, exemple:
**                          '/' vers 'accueil'        
*/

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// route de page d'acuille (affichage)
$app->get('/',function (Request $req , Response $res){
    
    return $this->view->render($res , $this->language.DIRECTORY_SEPARATOR.'accueil.php' , ["lang" => $this->language]);

})->setName('accueil');

// route de page d'inscription (affichage)
$app->get('/inscription' , function(Request $req , Response $res){

    return $this->view->render($res , $this->language.DIRECTORY_SEPARATOR.'inscription.php' , ["lang" => $this->language]);

})->setName('inscription');
