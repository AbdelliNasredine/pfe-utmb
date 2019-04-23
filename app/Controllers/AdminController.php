<?php

namespace App\Controllers;

use App\Models\Document;
use App\Models\User;

class AdminController extends BaseController
{
    /* méthod d'affichage de page d'administration */
    public function index($request, $response)
    {
        if($this->auth->isAdminConnected()){
            // un peut de statistique

            return $this->view->render($response, 'admin/admin.view.twig', 
                [
                    'nbPfes'  => Document::all()->count(),
                    'nbUsers' => User::all()->count(),
                    'lastusers' => User::where('etat',0)->orderBy('date_inscription','desc')->get(),
                    'lastdocuments' => Document::where('valid',0)->where('user_id','<>',0)->orderBy('date_publication','desc')->get(),
                ]
            );    
        }else{
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
    /*  méthod d'affciahe de page de login */
    public function getlogin($request,$response)
    {
        if($this->auth->isAdminConnected()){
            return $response->withRedirect($this->router->pathFor('dashboard'));
        }else{
            return $this->view->render($response, 'admin/login.view.twig', []); 
        }
    }

    /*  méthod de login (traitement) */
    public function postlogin($request,$response)
    {
        if($this->auth->isAdminConnected()){
            return $response->withRedirect($this->router->pathFor('dashboard'));
        }else{
            // recupaire les donnée envoyer :
            $identifiant = filter_var( $request->getParam('i') , FILTER_SANITIZE_STRING );
            $password = filter_var( $request->getParam('p' , FILTER_SANITIZE_STRING) );

            // verifier les donnée ( es ce que c'est un admin valide)
            if( !$this->auth->verifieAdmin($identifiant , $password) ){
                // erreur 
                $this->flash->addMessage('errors', "Idenrifiant ou mot de pass erronée !");
                return $response->withRedirect($this->router->pathFor('admin-login'));
            }

            // bien
            // redirige vers le "dashbord" 
            return $response->withRedirect($this->router->pathFor('dashboard'));
        } 
    }

    /*  méthod de deconnection */
    public function getlogout($request , $response)
    {
        if( $this->auth->isAdminConnected() ){
            $this->auth->deconnecter();
            return $response->withRedirect($this->router->pathFor('home'));
        }else{
            $this->flash->addMessage('errors', "Connecter avant de faire ça !");
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
    /* méthod de page administartion->utilisateurs */
    public function user($request,$response)
    {
        if($this->auth->isAdminConnected()){
            return $this->view->render($response, 'admin/admin.users.view.twig', 
                [
                    'users' => User::where('etat',1)->orderBy('date_inscription','desc')->get(),
                ]
            );    
        }else{
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
    /* méthod de page administartion->archive */
    public function archive($request,$response)
    {
        if($this->auth->isAdminConnected()){
            // recupaire tout les documents :
            $documents = Document::all();
            return $this->view->render($response, 'admin/admin.archive.view.twig' ,['docs' => $documents]);    
        }else{
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
    /* méthod d'ajoute un utilsateur */
    public function addUser($request,$response)
    {
        // recupairer les donner :
        $nom = filter_var($request->getParam('nom'),FILTER_SANITIZE_STRING);
        $prenom = filter_var($request->getParam('prenom'),FILTER_SANITIZE_STRING);
        $email = filter_var($request->getParam('email'),FILTER_SANITIZE_STRING);
        $password = filter_var($request->getParam('pass'),FILTER_SANITIZE_STRING);
        $type = filter_var($request->getParam('type'),FILTER_SANITIZE_STRING);

        // obj de validation :
        $validation = $this->validator->validateAll($request, ['nom', 'prenom', 'email', 'pass','type']);

        // simple validation :
        if (!$validation->valid()) {

            // les champ ne sont pas valid (vide) :
            return $response->withRedirect($this->router->pathFor('admin-user-page'));

        }
        if (!$validation->isString($nom)) {

            // nom contint des caratére come (0-9 % ^ $ ... etc)
            $this->flash->addMessage('errors', "Champ Nom doit contenir seulement les alphabet !");
            return $response->withRedirect($this->router->pathFor('admin-user-page'));

        }
        if (!$validation->isString($prenom)) {

            // prenom contint des caratére come (0-9 % ^ $ ... etc)
            $this->flash->addMessage('errors', "Champ Prenom doit contenir seulement les alphabet !");
            return $response->withRedirect($this->router->pathFor('admin-user-page'));

        }
        if (!$validation->isEmail($email)) {

            // email déja utiliser :
            $this->flash->addMessage('errors', "Cette email adress est déja utiliser , utiliser une autre !");
            return $response->withRedirect($this->router->pathFor('admin-user-page'));

        }

        // aprés validation, on ajoute le nv user :
        User::create([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'type' => $type,
            'date_inscription' => date('Y-m-d h:i:s'),
            'profile_img' => null,
            'etat' => true,
        ]);

        // rediriger vers la page de admin-users
        $this->flash->addMessage('success', "Utilisateur a été ajouter avec succeé !");
        return $response->withRedirect($this->router->pathFor('admin-user-page'));
    }
    /* méthod d'affichage un document */
    public function viewDocument($request,$response , array $args)
    {
        if($this->auth->isAdminConnected()){
            $doc = Document::find((int) $args['id'] );
            return $this->view->render($response, 'admin/admin.document.view.twig',['doc' => $doc]);    
        }else{
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
    /* méthod de validation d'un document */
    public function validateDocument($request,$response , array $args)
    {
        if($this->auth->isAdminConnected()){
            $id = (int) $args['id'];
            $doc = Document::find($id);
            $doc->valid = 1;
            $doc->save();
            $this->flash->addMessage('success', "Document a été valider avec success");
            return $response->withRedirect($this->router->pathFor('admin-view-document',['id' => $id]));   
        }else{
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
    /* méthod de un document */
    public function deleteDocument($request,$response , array $args)
    {
        if($this->auth->isAdminConnected()){
            $id = (int) $args['id'];
            Document::destroy($id);
            $this->flash->addMessage('success', "Document ". $id ." supprimer avec succeé !");
            return $response->withRedirect($this->router->pathFor('admin-archive-page'));   
        }else{
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
    /* méthod d'acceptation de demende d'inscription  */
    public function acceptUser($request , $response , array $args)
    {
        if($this->auth->isAdminConnected()){
            $user_id = (int) filter_var($args['user_id'],FILTER_SANITIZE_NUMBER_INT);
            User::where('id',$user_id)->update(['etat' => 1]);
            $this->flash->addMessage('success', "demender inscription accepter !");
            return $response->withRedirect($this->router->pathFor('dashboard'));   
        }else{
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    } 
    public function deleteUser($request , $response , array $args)
    {
        if($this->auth->isAdminConnected()){
            $user_id = (int) filter_var($args['user_id'],FILTER_SANITIZE_NUMBER_INT);
            User::destroy($user_id);
            $this->flash->addMessage('success', "Utilisateur a été supprimer avec succée !");
            return $response->withRedirect($this->router->pathFor('admin-user-page'));   
        }else{
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    } 
}