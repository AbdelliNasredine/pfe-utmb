<?php

namespace App\Controllers;


use App\Models\User;
use App\Models\Document;

class UserController extends BaseController
{
    /* méthod d'affichage de page d'un utilisateur */

    public function index($request , $response)
    {
        /* recupaire les pfe de "user" */
        $user = $this->auth->user();
        $pfes = Document::where('user_id', $user->id)->get();        

        $path = $this->language . DIRECTORY_SEPARATOR . 'user/user.view.twig';
        return $this->view->render($response, $path, [
            "lang" => $this->language,
            "pfes"  => $pfes
        ]);
    }

    /* méthod de changement de mot de pass */
    public function postreset($request,$response)
    {
        /* recupaiere les donnée (nv_pass et nv_pass_conf ) */
        $orgPass = filter_var($request->getParam('org_pass') , FILTER_SANITIZE_STRING);
        $nvPass = filter_var($request->getParam('nv_pass'),FILTER_SANITIZE_STRING);
        $nvPassConf = filter_var($request->getParam('nv_pass_conf'),FILTER_SANITIZE_STRING);
        /* Test si la otg_pass est == a mote pass originale */
        if( !password_verify($orgPass,$this->auth->user()->password) ){
            /* erreur */
            $this->flash->addMessage('errors', "Ancien mot de passe erroné !");
            return $response->withRedirect($this->router->pathFor('user'));
        }
        /* test si la mot de pass < 6 carétaire */
        if( strlen($nvPass) < 6 ){
            /* erreur */
            $this->flash->addMessage('errors', "le mot de passe doit contenir au moins 6 caractères!");
            return $response->withRedirect($this->router->pathFor('user'));
        }
        /* test si la mot de pass == confirmation */
        if($nvPass !== $nvPassConf ){
            /* erreur */
            $this->flash->addMessage('errors', "la confirmation du mot de passe doit être identique au nouveaux mot de passe");
            return $response->withRedirect($this->router->pathFor('user'));
        }

        /* bien */
        /* sauvgardage de nv password */
        $userId = $this->auth->user()->id;
        User::where('id', $userId)->update([
            'password' => password_hash($nvPass, PASSWORD_DEFAULT)]
        );    

        /* rediriger vers la page de profils + msg de succée */
        $this->flash->addMessage('success', "Votre mot de pass a été changer avec succé ");
        return $response->withRedirect($this->router->pathFor('user'));        
    }
    /* méthod de changement de profil image */
    public function postProfilImg($request,$response)
    {
        /*
         * méthod "postProfilImg"
         */

        // le chemin (dossier):
        $dir = $this->container->get('profil_imgs_directory');


        // la fichier (.pdf,.doc,.docx,.word)
        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['profImg'];

        // validation de fichier :
        if( !empty($uploadedFile) ){
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $extention = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
                if(in_array($extention,['png','jpg','jpeg'])){
                    // succée 
                    // ajoute de photo au serveur
                    // test si l'utilisateur a déja un phot de profil
                    $profil_img = $this->auth->user()->profile_img ;
                    if( $profil_img != null ){
                        //déja img
                        unlink($dir . DIRECTORY_SEPARATOR . $profil_img) or die("en peut pas supprimer l'image");    
                    }
                    $filename = moveUploadedFile($dir, $uploadedFile);
                    // mise à joure la base de donnée :
                    User::find((int) $this->auth->user()->id)->update(['profile_img' => $filename]);
                }else{
                    // erreur : extention erronner != '.pdf','.doc','.word','.docx'
                    $this->flash->addMessage('errors', "veullez choisire une photo .png , .jpg , .jpeg");
                    return $response->withRedirect($this->router->pathFor('user'));
                }
            }else{
                // erreur : fichier pas uploader
                $this->flash->addMessage('errors', "Erreur l'ors d'upload de photo , réessayer");
                return $response->withRedirect($this->router->pathFor('user'));
            }
        }else{
            // erreur : no fichier uploader / taille trés large 
            $this->flash->addMessage('errors', 'Erreur photo trop large , essayez autre');
            return $response->withRedirect($this->router->pathFor('user'));
        }
        $this->flash->addMessage('success', 'succeé ! votre photo de profil a été ajouté avec succée !');
        return $response->withRedirect($this->router->pathFor('user'));

    } 
}