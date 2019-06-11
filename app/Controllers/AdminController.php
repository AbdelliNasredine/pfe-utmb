<?php

namespace App\Controllers;

use App\Models\Document;
use App\Models\User;
use App\Models\Categorie;
use App\Models\SousCategorie;
use App\Models\Evaluation;
use App\Models\DocumentType;
use App\Models\Message;

class AdminController extends BaseController
{
    /* méthod d'affichage de page d'administration */
    public function index($request, $response)
    {
        if ($this->auth->isAdminConnected()) {
            // un peut de statistique

            return $this->view->render(
                $response,
                'admin/admin.view.twig',
                [
                    'nbPfes'  => Document::where('valid', 1)->count(),
                    'nbUsers' => User::whereHas('type', function ($q) {
                        $q->where('nom', '<>', 'admin');
                    })->where('etat', 1)->count(),
                    'nbEvaluations' => Evaluation::count(),
                    'lastdocuments' => Document::where('valid', 0)->orderBy('date_publication', 'desc')->get(),
                ]
            );
        } else {
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
    /* méthod d'affichage de page des message de contact */
    public function messgaes($request, $response)
    {
        if ($this->auth->isAdminConnected()) {
            return $this->view->render($response, 'admin/admin.message.view.twig', [
                'msgs' => Message::all()
            ]);
        } else {
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
    /* méthod d'affichage de page de compte admin */
    public function compte($request, $response)
    {
        if ($this->auth->isAdminConnected()) {
            return $this->view->render($response, 'admin/admin.compte.view.twig');
        } else {
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
    /*  méthod d'affciahe de page de login */
    public function getlogin($request, $response)
    {
        if ($this->auth->isAdminConnected()) {
            return $response->withRedirect($this->router->pathFor('dashboard'));
        } else {
            return $this->view->render($response, 'admin/login.view.twig', []);
        }
    }
    /*  méthod de login (traitement) */
    public function postlogin($request, $response)
    {
        if ($this->auth->isAdminConnected()) {
            return $response->withRedirect($this->router->pathFor('dashboard'));
        } else {
            // recupaire les donnée envoyer :
            $identifiant = filter_var($request->getParam('i'), FILTER_SANITIZE_STRING);
            $password = filter_var($request->getParam('p', FILTER_SANITIZE_STRING));

            // verifier les donnée ( es ce que c'est un admin valide)
            if (!$this->auth->verifieAdmin($identifiant, $password)) {
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
    public function getlogout($request, $response)
    {
        if ($this->auth->isAdminConnected()) {
            $this->auth->deconnecterAdmin();
            return $response->withRedirect($this->router->pathFor('home'));
        } else {
            $this->flash->addMessage('errors', "Connecter avant de faire ça !");
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
    /* méthod de page administartion->utilisateurs */
    public function user($request, $response)
    {
        if ($this->auth->isAdminConnected()) {
            return $this->view->render(
                $response,
                'admin/admin.users.view.twig',
                [
                    'users' => User::whereHas('type', function ($q) {
                        $q->where('nom', '<>', 'admin');
                    })->orderBy('date_inscription', 'desc')->get(),
                ]
            );
        } else {
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
    /* méthod de page administartion->archive */
    public function archive($request, $response)
    {
        if ($this->auth->isAdminConnected()) {
            // recupaire tout les documents :
            $documents = Document::all();
            return $this->view->render($response, 'admin/admin.archive.view.twig', ['docs' => $documents]);
        } else {
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
    /* méthod d'ajoute un utilsateur */
    public function addUser($request, $response)
    {
        // recupairer les donner :
        $nom = filter_var($request->getParam('nom'), FILTER_SANITIZE_STRING);
        $prenom = filter_var($request->getParam('prenom'), FILTER_SANITIZE_STRING);
        $email = filter_var($request->getParam('email'), FILTER_SANITIZE_STRING);
        $password = filter_var($request->getParam('pass'), FILTER_SANITIZE_STRING);
        $type = filter_var($request->getParam('type'), FILTER_SANITIZE_NUMBER_INT);

        // obj de validation :
        $validation = $this->validator->validateAll($request, ['nom', 'prenom', 'email', 'pass', 'type']);

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
            'user_types_id' => $type,
            'date_inscription' => date('Y-m-d h:i:s'),
            'profile_img' => null,
            'etat' => true,
        ]);

        // rediriger vers la page de admin-users
        $this->flash->addMessage('success', "Utilisateur a été ajouter avec succeé !");
        return $response->withRedirect($this->router->pathFor('admin-user-page'));
    }
    /* méthod d'affichage un document */
    public function viewDocument($request, $response, array $args)
    {
        if ($this->auth->isAdminConnected()) {
            $doc = Document::find((int)$args['id']);
            $evals = Evaluation::where('documents_id',$doc->id)->orderBy('date','desc')->get();
            return $this->view->render($response, 'admin/admin.document.view.twig', ['doc' => $doc , 'evals' => $evals]);
        } else {
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
    /* méthod de validation d'un document */
    public function validateDocument($request, $response, array $args)
    {
        if ($this->auth->isAdminConnected()) {
            $id = (int)$args['id'];
            $doc = Document::find($id);
            $doc->valid = 1;
            $doc->save();
            $this->flash->addMessage('success', "Document a été valider avec success");
            return $response->withRedirect($this->router->pathFor('admin-view-document', ['id' => $id]));
        } else {
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
    /* méthod de un document */
    public function deleteDocument($request, $response, array $args)
    {
        if ($this->auth->isAdminConnected()) {
            $id = (int)$args['id'];
            $doc_url = Document::find($id)->url;
            $dir =  $this->container->get('upload_directory');
            unlink($dir . DIRECTORY_SEPARATOR . $doc_url) or die("en peut pas supprimer l'image");
            // leur evaluations
            Document::find($id)->evaluations()->delete();
            // supr le doc
            Document::destroy($id);
            $this->flash->addMessage('success', "Document " . $id . " supprimer avec succeé !");
            return $response->withRedirect($this->router->pathFor('admin-archive-page'));
        } else {
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
    /* méthod d'acceptation de demende d'inscription  */
    public function acceptUser($request, $response, array $args)
    {
        if ($this->auth->isAdminConnected()) {
            $user_id = (int)filter_var($args['user_id'], FILTER_SANITIZE_NUMBER_INT);
            User::where('id', $user_id)->update(['etat' => 1]);
            $this->flash->addMessage('success', "Succée !");
            return $response->withRedirect($this->router->pathFor('admin-user-page'));
        } else {
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
    /*  méthod de réuse de demende d'inscription */
    public function refuseUser($request, $response, array $args)
    {
        if ($this->auth->isAdminConnected()) {
            $user_id = (int)filter_var($args['user_id'], FILTER_SANITIZE_NUMBER_INT);
            User::where('id', $user_id)->update(['etat' => -1]);
            $this->flash->addMessage('success', "Utilisateur a été blocker !");
            return $response->withRedirect($this->router->pathFor('admin-user-page'));
        } else {
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
    public function deleteUser($request, $response, array $args)
    {
        if ($this->auth->isAdminConnected()) {
            $user_id = (int)filter_var($args['user_id'], FILTER_SANITIZE_NUMBER_INT);
            User::destroy($user_id);
            $this->flash->addMessage('success', "Utilisateur a été supprimer avec succée !");
            return $response->withRedirect($this->router->pathFor('admin-user-page'));
        } else {
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
    /* méthod d'affichage de page documen->addDocument  */
    public function getaddDocument($request, $response)
    {
        if ($this->auth->isAdminConnected()) {
            return $this->view->render($response, 'admin/admin.document.add.view.twig', [
                'doc_types' => DocumentType::all()
            ]);
        } else {
            return $response->withRedirect($this->router->pathFor('admin-login'));
        }
    }
    public function addDocument($request, $response)
    {
        // le chemin d'acrchive (dossier):
        $dir = $this->container->get('upload_directory');


        // la fichier (.pdf,.doc,.docx,.word)
        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['doc'];

        // validation de fichier :
        if (!empty($uploadedFile)) {
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $extention = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
                if (in_array($extention, ['pdf', 'doc', 'word', 'docx'])) {
                    // succée 
                    $sousCategorie = SousCategorie::find((int)$request->getParam('domaine'));

                    // géneration de référence doc :
                    $ref = genrateREF(
                        $this->db::select('select MAX(id) AS lastId from documents'),
                        $request->getParam('type'),
                        $sousCategorie->categorie_id,
                        $sousCategorie->id
                    );
                    $filename = moveUploadedFile($dir, $ref, $uploadedFile);
                    $filesize = $uploadedFile->getSize() / (1024 * 1024);
                    $filesize = number_format((float)$filesize, 2, '.', '');
                    // convertire au pdf :
                    // test si extensien != .pdf
                    if ($extention != 'pdf') {
                        // en convertire la fichier
                        // var_dump('start /wait soffice --headless --convert-to pdf --oudir '.$dir.' '.$dir.DIRECTORY_SEPARATOR.$filename.'');
                        // die();
                        $chemin = $dir . DIRECTORY_SEPARATOR . $filename;
                        // var_dump($chemin);
                        // die();    
                        shell_exec('start /wait soffice -headless -convert-to pdf ' . $chemin . ' -outdir ' . $dir);
                        // supprime la fichier orginall
                        unlink($dir . DIRECTORY_SEPARATOR . $filename) or die("ereur de suppression");
                        $ext = ['.word', '.docx', '.doc'];
                        $filename = str_replace($ext, ".pdf", $filename);
                        // var_dump($filename);
                        // die();
                    }
                    // ajoute de document dans la base de donnée :
                    Document::create([
                        'ref' => $ref,
                        'auteur' => $request->getParam('auteur'),
                        'titre'  => $request->getParam('titre'),
                        'resume' => $request->getParam('resume'),
                        'langue' => $request->getParam('langue'),
                        'universite' => $request->getParam('univ'),
                        'taille' =>  $filesize . 'MB',
                        'specialite' => $request->getParam('spes'),
                        'url' => $filename,
                        'users_id' => $this->auth->admin()->id,
                        'valid' => true,
                        'categories_id' => $sousCategorie->categorie_id,
                        'sous_categories_id' => $sousCategorie->id,
                        'document_type_id'   => (int)$request->getParam('type'),
                    ]);
                } else {
                    // erreur : extention erronner != '.pdf','.doc','.word','.docx'
                    $this->flash->addMessage('errors', "veullez choisire une fichier .pdf , .doc , .docx , .word");
                    return $response->withRedirect($this->router->pathFor('admin-add-document'));
                }
            } else {
                // erreur : fichier pas uploader
                $this->flash->addMessage('errors', "Erreur l'ors d'upload de fichier , réessayer");
                return $response->withRedirect($this->router->pathFor('admin-add-document'));
            }
        } else {
            // erreur : no fichier uploader / taille > 8 mega
            $this->flash->addMessage('errors', 'Erreur fichier supperiour à 20 méga, essayez autre');
            return $response->withRedirect($this->router->pathFor('admin-add-document'));
        }
        $this->flash->addMessage('success', 'succeé ! le document a été ajouter avec succée ');
        return $response->withRedirect($this->router->pathFor('admin-archive-page'));
    }
    public function updateDocument($request, $response, array $args)
    {
        // updating the document information :
        // whith given id
        $docId = (int)$args['docid'];
        $sousCategorie = SousCategorie::find($request->getParam('domaine'));
        Document::where('id', $docId)->update([
            'auteur' => $request->getParam('auteur'),
            'titre'  => $request->getParam('titre'),
            'resume' => $request->getParam('resume'),
            'langue' => $request->getParam('langue'),
            'universite' => $request->getParam('univ'),
            'specialite' => $request->getParam('spes'),
            'categories_id' => $sousCategorie->categorie_id,
            'sous_categories_id' => $sousCategorie->id,
            'document_type_id'   => (int)$request->getParam('type'),
        ]);
        $this->flash->addMessage('success', 'succeé ! le document a été modifier succée ');
        return $response->withRedirect($this->router->pathFor('admin-archive-page'));
    }
    public function changeInfomration($request, $response)
    {
        $nom = $request->getParam('nom');
        $prenom = $request->getParam('prenom');
        if (empty($nom) ||  empty($prenom)) {
            $this->flash->addMessage('errors', 'Nom et prénom ne doit pas étre vide');
            return $response->withRedirect($this->router->pathFor('admin-compte-page'));
        }

        User::where('id', $this->auth->admin()->id)->update([
            'nom' => $nom,
            'prenom' => $prenom
        ]);

        $this->flash->addMessage('success', 'Information modifier avec succée ');
        return $response->withRedirect($this->router->pathFor('admin-compte-page'));
    }
    public function changePassword($request, $response)
    {
        $oldPassword = $request->getParam('old');
        $newPassword = $request->getParam('new');

        $admin = $this->auth->admin();

        // var_dump($oldPassword,$newPassword);
        // die();

        // tester si mot de passe enciene est corréte
        if (!password_verify($oldPassword, $admin->password)) {
            $this->flash->addMessage('errors', 'Ancien mot de passe incorréte !');
            return $response->withRedirect($this->router->pathFor('admin-compte-page'));
        }

        // tester la taille de nv password
        if (strlen($newPassword) < 6) {
            $this->flash->addMessage('errors', 'Nouveaux Mot de passe trés courts');
            return $response->withRedirect($this->router->pathFor('admin-compte-page'));
        }

        // Ancien mot de passe est corréte :
        // Modification de mot de passe :
        User::where('id', $admin->id)->update([
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        $this->flash->addMessage('success', 'Mot de passe modifier avec succée !');
        return $response->withRedirect($this->router->pathFor('admin-compte-page'));
    }
    public function changeProfilImage($request, $response)
    {
        // le chemin (dossier):
        $dir = $this->container->get('profil_imgs_directory');


        // la fichier (.pdf,.doc,.docx,.word)
        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['profImg'];

        // validation de fichier :
        if (!empty($uploadedFile)) {
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $extention = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
                if (in_array($extention, ['png', 'jpg', 'jpeg'])) {
                    // succée 
                    // ajoute de photo au serveur
                    // test si un admin a déja un phot de profil
                    $profil_img = $this->auth->admin()->profile_img;
                    if ($profil_img != null) {
                        //déja img
                        unlink($dir . DIRECTORY_SEPARATOR . $profil_img) or die("en peut pas supprimer l'image");
                    }
                    $filename = moveUploadedFile($dir, null, $uploadedFile);
                    // mise à joure la base de donnée :
                    User::find((int)$this->auth->admin()->id)->update(['profile_img' => $filename]);
                } else {
                    // erreur : extention erronner != '.pdf','.doc','.word','.docx'
                    $this->flash->addMessage('errors', "veullez choisire une photo .png , .jpg , .jpeg");
                    return $response->withRedirect($this->router->pathFor('admin-user-page'));
                }
            } else {
                // erreur : fichier pas uploader
                $this->flash->addMessage('errors', "Erreur l'ors d'upload de photo , réessayer");
                return $response->withRedirect($this->router->pathFor('admin-user-page'));
            }
        } else {
            // erreur : no fichier uploader / taille trés large 
            $this->flash->addMessage('errors', 'Erreur photo trop large , essayez autre');
            return $response->withRedirect($this->router->pathFor('admin-user-page'));
        }
        $this->flash->addMessage('success', 'succeé ! votre photo de profil a été ajouté avec succée !');
        return $response->withRedirect($this->router->pathFor('admin-user-page'));
    }
}
