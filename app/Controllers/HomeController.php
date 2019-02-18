<?php

namespace App\Controllers;

Class HomeController  extends BaseController {

    //index méthod : page d'accuile
    public function index($request , $response){
        return $this->view->render($response , 
            $this->language.DIRECTORY_SEPARATOR.'accueil.php' ,
            ["lang" => $this->language]
        );
    }
}