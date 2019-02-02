<?php
/*
**  la Class 'Controller' :
**      -   instancier l'attribut '$contianer' qui
**          contiant tout les depandace de app , comme
**          l'object de connection , moteur des vue ... etc
**      -   Tout les autres controllers heirite de cette class 
**
*/
use \Slim\Views\PhpRenderer as view;

namespace App\Controllers;

class Controller {

    protected $container;

    public function __construct($container){

        $this->container = $container;

    }

    public function __get($obj){

        if ($this->container->{$obj}) {

            return $this->container->{$obj};
        
        }

    }

}