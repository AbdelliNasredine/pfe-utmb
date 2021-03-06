<?php

namespace App\Controllers;


use App\Models\User;

class UserController extends BaseController
{
    /* méthod d'affichage de page d'un utilisateur */

    public function index($request , $response)
    {
        /* recupaire les pfe de "user" */
        $user = $this->auth->user();
        $pfes = $user->documents()->get(); 
        
        // var_dump($pfes);
        // die();

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
                    $filename = moveUploadedFile($dir,null, $uploadedFile);
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
    /* méthod de recupiare user detail */
    public function userdetails($request,$response)
    {
        $id = (int) filter_var($request->getParam('user_id'),FILTER_VALIDATE_INT);
        $user = User::find($id);
        $img = $user->profile_img == null ? "default.png" : $user->profile_img;
        $details = '
        <div class="table-responsive">  
            <table class="table table-borderless table-striped">
        ';

        $details .= '
        <tr>  
             <td width="30%"><label class="font-weight-bold">Image de profil</label></td>  
             <td width="70%">
                <img src="/public/img/profiles/'. $img .'" alt="profil image" class="img-thumbnail" width="45" height="45">
             </td>  
        </tr>   
        <tr>  
             <td width="30%"><label class="font-weight-bold">Nom</label></td>  
             <td width="70%" class="text-muted">'.$user->nom.'</td>  
        </tr>  
        <tr>  
             <td width="30%"><label class="font-weight-bold">Prénom</label></td>  
             <td width="70%" class="text-muted">'.$user->prenom.'</td>  
        </tr>  
        <tr>  
             <td width="30%"><label class="font-weight-bold">Email</label></td>  
             <td width="70%" class="text-muted">'.$user->email.'</td>  
        </tr>  
        <tr>  
            <td width="30%"><label class="font-weight-bold">Type</label></td>  
            <td width="70%" class="text-muted">'.$user->type->nom.'</td>  
        </tr>          
        ';

        $details .= '
            </table>
        </div>';
        echo $details;
    }
    public function getEditUser($request , $response )
    {
        $user_id = (int) filter_var($request->getParam('user_id'),FILTER_SANITIZE_NUMBER_INT); 
        $user = User::find($user_id);
        $editForm = '<form action="'.$this->router->pathFor('edit-user').'?id='.$user_id.'" method="POST">'; 
        $editForm .= '<label class="text-muted">Nom :</label>';
        $editForm .= '<input type="text" class="form-control" name="nom" value="'. $user->nom .'" required/>';
        $editForm .= '<label class="text-muted">Prénom :</label>';
        $editForm .= '<input type="text" class="form-control" name="prenom" value="'. $user->prenom .'" required/>';
        $editForm .= '<label class="text-muted">Email :</label>';
        $editForm .= '<input type="text" class="form-control" name="email"  placeholder="'. $user->email .'"/>';
        $editForm .= '<label class="text-muted">Type :</label>';
        $editForm .= '<select class="custom-select" name="type">
                            <option value="" selected></option>
                            <option value="2">Etudiant</option>
                            <option value="3">Enseigniant</option> 
                    <select/>';  
        $editForm .= '<label class="text-muted mt-3 mr-3">Changer état :</label>';
        if( $user->etat == 1 ){
            $editForm .= '<a href="/admin/refuse-user/'.$user->id.'" class="btn btn-danger"> blocker </a>';
        }else{
            $editForm .= '<a href="/admin/accept-user/'.$user->id.'" class="btn btn-success"> déblocker </a>';
        }
        $editForm .='<br>';  
        $editForm .= '<input type="submit" class="btn btn-success mt-3 mr-2" value="modifier"/>';
        $editForm .= '<input type="reset" class="btn btn-secondary mt-3" value="reset"/>';
        $editForm .= '</form>';
        echo $editForm;
    } 
    public function postEditUser($request , $response , array $args)
    {
        if($this->auth->isAdminConnected()){
            // validation des donnée envoyeé
            $validation = $this->validator->validateAll($request, ['nom', 'prenom']);

            // filtrage de donnée :
            $nom = filter_var($request->getParam('nom'), FILTER_SANITIZE_STRING);
            $prenom = filter_var($request->getParam('prenom'), FILTER_SANITIZE_STRING);
            $email = filter_var($request->getParam('email'), FILTER_SANITIZE_EMAIL);
            $password = filter_var($request->getParam('password'), FILTER_SANITIZE_STRING);
            $passwordConfirmation = filter_var($request->getParam('passwordConf'), FILTER_SANITIZE_STRING);
            $type = filter_var($request->getParam('type'),FILTER_SANITIZE_NUMBER_INT);
            $user_id = (int) filter_var($request->getParam('id'),FILTER_SANITIZE_NUMBER_INT);
            // Les Tests de validation :
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

            if( $password !== $passwordConfirmation ){
                $this->flash->addMessage('errors', "mot de pass ne corréspond pas au mot pass de confirmation");
                return $response->withRedirect($this->router->pathFor('admin-user-page')); 
            }

            if(!empty($nom)){
                User::where('id',$user_id)->update([
                    'nom' => $nom,
                ]);
            }

            if(!empty($prenom)){
                User::where('id',$user_id)->update([
                    'prenom' => $prenom,
                ]);
            }

            if(!empty($email)){
                User::where('id',$user_id)->update([
                    'email' => $email,
                ]);
            }


            if(!empty($password)){
                User::where('id',$user_id)->update([
                    'password' => password_hash($password,PASSWORD_DEFAULT),
                ]);
            }

            if(!empty($type)){
                User::where('id',$user_id)->update([
                    'user_types_id' => $type,
                ]);
            }

            $this->flash->addMessage('success', "Utilisateur a été modifier avec succée !");
            return $response->withRedirect($this->router->pathFor('admin-user-page'));   
        }else{
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
}