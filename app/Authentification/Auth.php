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
        $user = User::whereHas('type', function($q){
            $q->where('nom','<>', 'admin');
        })->where('email', $email)->first();

        if (!$user) {
            // information erronée
            return false;
        }

        if (password_verify($password, $user->password)) {
            if($user->etat == 0 ){
                // pas ancore verfier
                return -1;
            }
            if( $user->etat == -1 ){
                // demede réfuser
                return -2;
            }
            // OK
            $_SESSION['user'] = $user->id;
            return true;
        }

        return false;
    }

    /*
     * méthod verifieAdmin : verfie si il y a un 'admin' avec 
     * le login et mot de passe
     */
    public function verifieAdmin($e, $p)
    {
        $admin = User::whereHas('type', function($q){
            $q->where('nom', 'admin');
        })->where('email', $e)->first();


        if(!$admin){
            return false;
        }

        if(password_verify($p , $admin->password)){
            $_SESSION['admin'] = $admin->id;
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
     *  méthod isAdminConnected : verifie si il y a un 'admin' est connecter
     */
    public function isAdminConnected(){
        return isset($_SESSION['admin']);
    }

    /*
     * méthod deconnecter : Vider la session de user ( user connecter )
     */
    public function deconnecter()
    {
        unset($_SESSION['user']);
    }

    /*
     * méthod deconnecter administarteur : Vider la session de user ( user connecter )
     */
    public function deconnecterAdmin()
    {
        unset($_SESSION['admin']);
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

    /*
     * méthod admin : renvoi les donnée de admin connecter ( dans la suppGlobal _SESSION )
     */
    public function admin()
    {
        if (isset($_SESSION['admin'])) {
            return User::find($_SESSION['admin']);
        }
    }
}
