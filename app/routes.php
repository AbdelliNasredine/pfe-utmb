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
use \App\Middleware\VisiteurMiddleware;
use \App\Middleware\AuthMiddleware;

/*
** HomeController routes
*/
/*  Accesible pour Tout (Connecter / non-connecter) */
$app->get('/', 'HomeController:index')->setName('home');
$app->get('/a-propos','HomeController:propos')->setName('a-propos');
$app->get('/categorie[/{categorieNom}[/{sousCategorieNom}]]', 'CategorieController:getCategories')
    ->setName('categorie');
$app->get('/document/{id}' , 'DocumentController:getDocument')->setName('document');
$app->get('/recherche','RechercheController:index')->setName('search');

/*
 *
 *  - route groupe pour proteger l'accees au certiane
 *    'Root/Page' d'application
*/
/* Si l'utilisateur n'est pas connecter (Visiteur) */
$app->group('', function () {
    $this->get('/inscription', 'AuthController:getReg')->setName('inscription');
    $this->post('/inscription', 'AuthController:postReg');
    $this->get('/connection', 'AuthController:getCon')->setName('connection');
    $this->post('/connection', 'AuthController:postCon');
    $this->get('/reinitialiser', 'AuthController:getReset')->setName('reinitialiser');
    $this->post('/reinitialiser', 'AuthController:postReset');
    $this->map(['GET', 'POST'], '/contact', 'HomeController:contact')->setName('envoyer');
})->add(new VisiteurMiddleware($container));
/*  Si l'utilisateur est connecter */
$app->group('', function () {
    $this->get('/user','UserController:index')->setName('user');
    $this->post('/add-pfe','DocumentController:addDocument')->setName('add-pfe');
    $this->get('/admin','AdminController:index')->setName('admin');
    $this->get('/deconnecter', 'AuthController:getDeCon')->setName('deconnecter');
})->add(new AuthMiddleware($container));













//--------------------------- TESTING ---------------------------------------------------------------
// // route de page d'acuille (affichage)
// $app->get('/',function (Request $req , Response $res){

//     return $this->view->render($res , $this->language.DIRECTORY_SEPARATOR.'accueil.php' , ["lang" => $this->language]);

// })->setName('accueil');

// route de page d'inscription (affichage)

// // {?} test root :
// $app->get('/posttest' , function(Request $req , Response $res){

//     $resutlt = $this->db->query(" SELECT * FROM jeux_video")->fetchAll(PDO::FETCH_ASSOC);
//     // $json_data = array();
//     // while ( $r = $resutlt->fetchAll(PDO::FETCH_ASSOC)){
//     //     $json_data['data'] = $r;
//     // }
//     // var_dump($resutlt);
//     // die();
//     $nvres = $res->withHeader('Content-type', 'application/json');
//     return $nvres->withJson($resutlt);
// }); 

// $app->get('/test' , function(Request $req , Response $res){
//     return $this->view->render($res , '/test/test.php' , []);
// });
// ----------------------------------------------------------------------------------------------------
