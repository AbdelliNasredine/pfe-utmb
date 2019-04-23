<?php

namespace App\Controllers;

use App\Models\Evaluation;

class EvaluationController extends BaseController 
{
    /* méthod d'ajoute de evaluation */
    public function addEvaluation($request,$response, array $args){
        // recupaire les donnée :
        $eval_nb = (int) $request->getParam('eval');
        $eval_contenu = $request->getParam('eval-contenu');

        // ajoute de evaluation dans la table :
        Evaluation::create([
            'users_id' => $this->auth->user()->id,
            'documents_id' =>  (int) $args['docId'],
            'contenu' => $eval_contenu,
            'date' => date('Y-m-d h:i:s'),
            'nb' =>  $eval_nb
        ]);

        // rediriger vers la page de document + message de succée
        $this->flash->addMessage('success', "votre évaluation a été ajouter avec succée");
        return $response->withRedirect($this->router->pathFor('document', array('id' => (int) $args['docId'])));

    }
}