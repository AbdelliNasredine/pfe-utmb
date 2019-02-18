<?php

namespace App\Controllers;

use App\Models\User;

Class AuthController  extends BaseController {

    public function getReg($request , $response){
        return $this->view->render($response , 
            $this->language.DIRECTORY_SEPARATOR.'inscription.php' , 
            ["lang" => $this->language]
        );
    }
    public function postReg($request , $response){
        
        $user = User::create([
            'nom'    => $request->getParam('nom'),
            'prenom' => $request->getParam('prenom'),
            'email'  => $request->getParam('email'),
            'pass'   => $request->getParam('pass'),
            'type'   => $request->getParam('type'),
        ]);

        return $response->withRedirect($this->router->pathFor('home'));

    }

}