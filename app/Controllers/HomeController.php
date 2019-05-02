<?php

namespace App\Controllers;

use App\Models\Message;
use App\Models\Document;

class HomeController extends BaseController

{

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* methode qui gére l'affchage de page d'accuile */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    public function index($request, $response)
    {
        $path = $this->language . DIRECTORY_SEPARATOR . 'accueil.twig';
        return $this->view->render($response, $path, 
        [
            "lang" => $this->language,
            "pfes" => Document::where('valid',true)->orderBy('date_publication','desc')->limit(10)->get(),
            "all" => Document::where('valid',true)->orderBy('date_publication','desc')->get()
        ]);
    }
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* methode qui gére l'affchage de page d'accuile */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    public function propos($request, $response)
    {
        $path = $this->language . DIRECTORY_SEPARATOR . 'a-propos.twig';
        return $this->view->render($response, $path, ["lang" => $this->language]);
    }
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* methode qui gére la formulaire de contact (contacter nous) */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    public function contact($request, $response)
    {
        // a faire : en utiliser une appel asycronne (json/xml)
        // variable $err et $data
        //  - $err pour les erreur
        //  - $data pour l'infomation a envoyer(json)
        $err = array();
        $data = array();

        // information envoyer par POST :
        // filtrage :
        $nom = filter_var($request->getParam('nom'), FILTER_SANITIZE_STRING);
        $email = filter_var($request->getParam('email'), FILTER_SANITIZE_EMAIL);
        $titre = filter_var($request->getParam('titre'), FILTER_SANITIZE_STRING);
        $contenu = htmlspecialchars($request->getParam('contenu'));

        // valiation des donnée :
        // nom , email , titre , contenu
        if (empty($nom)) {
            $err['nom'] = "Champ nom ne doit étre vide";
        }
        if (empty($email)) {
            $err['email'] = "Champ email ne doit étre vide";
        }
        if (empty($titre)) {
            $err['titre'] = "Champ titre ne doit étre vide";
        }
        if (empty($contenu)) {
            $err['contenu'] = "Champ contenu ne doit étre vide";
        }

        // test si il ya un erreur de validation
        if (!empty($err)) {
            // il 1 ou * erreur(s)
            $data['success'] = false;
            $data['errors'] = $err;
        } else {
            // non erreur de validation

            // sauvgarder le message dans la table 'messages' :
            Message::create([
                'nom' => $nom,
                'email' => $email,
                'titre' => $titre,
                'contenu' => $contenu,
                'date' => date("Y-m-d"),
            ]);
            $data['success'] = true;
        }

        // renvoi la reponse:
        return $response->withJson($data);
    }
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
}
