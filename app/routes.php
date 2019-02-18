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

$app->get('/','HomeController:index')->setName('home');
$app->get('/inscription' ,'AuthController:getReg')->setName('inscription');
$app->post('/inscription' ,'AuthController:postReg');















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

