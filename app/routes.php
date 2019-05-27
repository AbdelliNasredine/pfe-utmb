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
use \App\Middleware\AdminMiddleware;

/*
** HomeController routes
*/
/*  Accesible pour Tout (Connecter / non-connecter) sauf l'admin */
$app->group('', function(){
    $this->get('/', 'HomeController:index')->setName('home');
    $this->get('/a-propos','HomeController:propos')->setName('a-propos');
    $this->get('/categorie[/{categorieNom}[/{sousCategorieNom}]]', 'CategorieController:getCategories')
        ->setName('categorie');
    $this->get('/document/{id}' , 'DocumentController:getDocument')->setName('document');
    $this->get('/search','RechercheController:index')->setName('search');
    $this->get('/search/s/{word}','RechercheController:simpleSearch');  
    $this->get('/search/a','RechercheController:advanceSearch');    
})->add( new AdminMiddleware($container) );
$app->get('/download/{url}','DocumentController:downloadDocument')->setName('download');
$app->map(['GET', 'POST'], '/contact', 'HomeController:contact')->setName('envoyer');
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
})->add(new VisiteurMiddleware($container))
  ->add( new AdminMiddleware($container));
/*  Si l'utilisateur est connecter */
$app->group('', function () {
    $this->get('/user','UserController:index')->setName('user');
    $this->post('/user/reset-password','UserController:postreset')->setName('user-password');
    // user-profil-img
    $this->post('/user/add-profil-image','UserController:postProfilImg')->setName('user-profil-img');
    $this->get('/delete-document/{id}','DocumentController:deletDocument')->setName('delete-pfe');
    $this->post('/add-pfe','DocumentController:addDocument')->setName('add-pfe');
    $this->post('/add-evaluation/{docId}','EvaluationController:addEvaluation')->setName('add-evaluation');
    $this->get('/deconnecter', 'AuthController:getDeCon')->setName('deconnecter');
})->add(new AuthMiddleware($container))
  ->add( new AdminMiddleware($container));


/* ------------ administration --------------- */
/*  Accesible pour la'admin seulement */
$app->group('' , function(){
    $this->get('/admin/login' , 'AdminController:getlogin')->setName('admin-login');
    $this->post('/admin/login' , 'AdminController:postlogin');
    $this->get('/admin','AdminController:index')->setName('dashboard');
    $this->get('/admin/user','AdminController:user')->setName('admin-user-page');
    $this->get('/admin/archive','AdminController:archive')->setName('admin-archive-page');
    $this->get('/admin/messages','AdminController:messgaes')->setName('admin-messages-page');
    $this->get('/admin/compte','AdminController:compte')->setName('admin-compte-page');
    $this->post('/admin/user/add','AdminController:addUser')->setName('admin-user-add');
    $this->get('/admin/logout' , 'AdminController:getlogout')->setName('admin-log-out');
    $this->post('/admin/pfe-details','DocumentController:documentDetails');
    $this->post('/admin/user-details','UserController:userdetails');
    $this->get('/admin/accept-user/{user_id}','AdminController:acceptUser')->setName('admin-accept-user');
    $this->get('/admin/refuse-user/{user_id}','AdminController:refuseUser')->setName('admin-refuse-user');
    $this->get('/admin/delet-user/{user_id}','AdminController:deleteUser')->setName('delete-user');
    $this->get('/admin/user-edit','UserController:getEditUser')->setName('edit-user');
    $this->post('/admin/user-edit','UserController:postEditUser');
    $this->get('/admin/document/{id}','AdminController:viewDocument')->setName('admin-view-document');
    $this->get('/admin/document/{id}/validate','AdminController:validateDocument')->setName('admin-validate-document');
    $this->get('/admin/document/{id}/delete','AdminController:deleteDocument')->setName('admin-delete-document');
    $this->post('/admin/document-add','AdminController:addDocument')->setName('admin-add-document');
    $this->get('/admin/document-add','AdminController:getaddDocument');
    $this->post('/admin/document-update/{docid}','AdminController:updateDocument')->setName('admin-update-document');
})->add(new VisiteurMiddleware($container));


