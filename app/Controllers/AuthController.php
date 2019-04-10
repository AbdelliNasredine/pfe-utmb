<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends BaseController
{

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* METHOD DE GESTION D'INSCRIPTION */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    public function getReg($request, $response)
    {
        $path = $this->language . DIRECTORY_SEPARATOR . 'inscription.twig';
        return $this->view->render($response, $path, ["lang" => $this->language]);
    }

    public function postReg($request, $response)
    {
        // validation des donnée envoyeé
        $validation = $this->validator->validateAll($request, ['nom', 'prenom', 'email', 'password', 'passwordConf']);

        // filtrage de donnée :
        $nom = filter_var($request->getParam('nom'), FILTER_SANITIZE_STRING);
        $prenom = filter_var($request->getParam('prenom'), FILTER_SANITIZE_STRING);
        $email = filter_var($request->getParam('email'), FILTER_SANITIZE_EMAIL);
        $password = filter_var($request->getParam('password'), FILTER_SANITIZE_STRING);
        $passwordConfirmation = filter_var($request->getParam('passwordConf'), FILTER_SANITIZE_STRING);
        $type = filter_var($request->getParam('type'),FILTER_SANITIZE_STRING);

        // Les Tests de validation :
        if (!$validation->valid()) {

            // les champ ne sont pas valid (vide) :
            return $response->withRedirect($this->router->pathFor('inscription'));

        }
        if (!$validation->isString($nom)) {

            // nom contint des caratére come (0-9 % ^ $ ... etc)
            $this->flash->addMessage('errors', "Champ Nom doit contenir seulement les alphabet !");
            return $response->withRedirect($this->router->pathFor('inscription'));

        }
        if (!$validation->isString($nom)) {

            // prenom contint des caratére come (0-9 % ^ $ ... etc)
            $this->flash->addMessage('errors', "Champ Prenom doit contenir seulement les alphabet !");
            return $response->withRedirect($this->router->pathFor('inscription'));

        }
        if (!$validation->isEmail($email)) {

            // email déja utiliser :
            $this->flash->addMessage('errors', "Cette email adress est déja utiliser , utiliser une autre !");
            return $response->withRedirect($this->router->pathFor('inscription'));

        }
        if (!$validation->isPassword($password, $passwordConfirmation)) {

            // mote de passe org déf au mote de pass de confirmation :
            $this->flash->addMessage('error', 'votre mot de passe ne correspond pas au mot de passe de confirmation');
            return $response->withRedirect($this->router->pathFor('inscription'));

        }

        // ajoute de nv utilisateur dans la base de données
        User::create([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'type' => $type,
            'etat' => true,
            'is_admin' => false,
        ]);

        // inscription fait avec succée !
        $this->flash->addMessage('global', 'Vous avais inscri ! vous pouvez connecter');
        return $response->withRedirect($this->router->pathFor('inscription'));

    }
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* methode qui gére la connection (get/post) */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    public function getCon($request, $response)
    {
        $path = $this->language . DIRECTORY_SEPARATOR . 'connection.twig';
        return $this->view->render($response, $path, ["lang" => $this->language]);
    }

    public function postCon($request, $response)
    {
        $auth = $this->auth->verifie(
            $request->getParam('email'),
            $request->getParam('password')
        );

        if (!$auth) {
            $this->flash->addMessage('global', 'Email ou mote de pass incorrecte !');
            return $response->withRedirect($this->router->pathFor('connection'));
        }

        return $response->withRedirect($this->router->pathFor('home'));

    }
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* methode qui gére la déconnection (get/post) */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    public function getDeCon($request, $response)
    {
        $this->auth->deconnecter();
        return $response->withRedirect($this->router->pathFor('home'));
    }
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    /* methode qui gére la réinitialiation de mot de passe (get/post) */
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    public function getReset($request, $response)
    {
        $path = $this->language . DIRECTORY_SEPARATOR . 'reset.twig';
        return $this->view->render($response, $path, ["lang" => $this->language]);
    }

    public function postReset($request, $response)
    {
        // recupirer l'utilisateur id s'il existe
        $userId = $this->auth->verifieByEmail(
            $request->getParam('email')
        );
        if (!$userId) {
            $this->flash->addMessage('global', 'Nous ne pouvons pas trouver un utilisateur avec cette adresse e-mail');
            return $response->withRedirect($this->router->pathFor('reinitialiser'));
        }

        // génerer la nouvelle mot de pass :
        $newPassword = randomString();

        // sauvgardage de nouvaux mot de pass dans la bd's
        // hasher la mote de pass avant l'ajoute dans la bd's :
        User::where('id', $userId)->update([
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)]
        );

        // message à envoye :
        $message = " Votre nouveaux mote de pass est :" . $newPassword;

        // envoyer l'email avec la nv mot de pass
        if ($this->mailer->send(
            null,
            $request->getParam('email'),
            'Site Adminstration',
            'Mote de passe reinitialisation',
            $message
        )) {
            $this->flash->addMessage('Succes', 'votre mot de passe a été envoyé à votre adresse e-mail !');
            return $response->withRedirect($this->router->pathFor('reinitialiser'));
        } else {
            $this->flash->addMessage('global', 'Un problème est survenu lors de l\'envoi du email ! ');
            return $response->withRedirect($this->router->pathFor('reinitialiser'));
        }
    }
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
}
