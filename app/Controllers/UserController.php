<?php

namespace App\Controllers;


use App\Models\User;

class UserController extends BaseController
{
    /* méthod d'affichage de page d'un utilisateur */
    public function index($request , $response){
        $path = $this->language . DIRECTORY_SEPARATOR . 'espace/user.view.twig';
        return $this->view->render($response, $path, ["lang" => $this->language]);
    }
}