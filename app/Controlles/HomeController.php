<?php
/*
**  'HomeController' gére tout requets relier  
**   avec la page d'acuille 'Homepage'
**
*/

namespace App\Controllers;

class HomeController extends Controller {

    public function index($request , $responce)
    {
        return $this->view->render($responce , '../Views/'.$this->language.DIRECTORY_SEPARATOR.'home.php' , []);
    }

    public function postregistre($request , $responce){
        return "Hello";
    }
}