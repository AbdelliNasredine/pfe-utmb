<?php

namespace App\Authentification;

use App\Models\User;

class Auth
{
    /*
     * Class d'Authentification
     */

    /*
     * méthod verifie : verfie si il y a un 'user' avec l'email
     *  et mot de pass passé come args
     */
    public function verifie($email, $password)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->pass)) {
            $_SESSION['user'] = $user->id;
            return true;
        }

        return false;
    }


    /*
     * méthod verifieByEmail : verfie si il y a un 'user' avec l'email
     *  passé come args
     */
    public function verifieByEmail($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return false;
        }

        return $user->id;
    }


    /*
     * méthod isConnected : verfie si il y a un 'user' connecter
     *  c-a-d , le supGlobal _SESSION contint l'id de user
     */
    public function isConnected()
    {
        return isset($_SESSION['user']);
    }

    /*
     * méthod deconnecter : Vider la session de user ( user connecter )
     */
    public function deconnecter()
    {
        unset($_SESSION['user']);
    }


    /*
     * méthod user : renvoi les donnée de user connecter ( dans la suppGlobal _SESSION )
     */
    public function user()
    {
        if (isset($_SESSION['user'])) {
            return User::find($_SESSION['user']);
        }
    }
}
