<?php

namespace App\Controllers;


use App\Models\Document;

class DocumentController extends BaseController
{
    public function getDocument($request , $response , array $args)
    {
        /*
         *  On recupaire le document par id ($args['id'])
         *  si ID de document existe
         *      alors
         *          on affiche le document avec leur info + evaluation ... etc
         *      sinon
         *          Message d'ereur 404
         */
        // filtrage de l'id :
        $id = filter_var($args['id'],FILTER_VALIDATE_INT);
        // recupairer le document
        $document = Document::where('id',$id)->first();
        // test si le document n'existe pas
        if(!$document){
            // ERREUR
            return $this->view->render($response, '404.twig');
        }
        // le document existe
        $path = $this->language . DIRECTORY_SEPARATOR . 'document/document.twig';
        return $this->view->render($response, $path , [
            "document" => $document
        ]);
    }

    public function addDocument($request,$response)
    {
        /*
         * Cette méthod "upload" un pfe au serveur
         */

        // le chemin d'acrchive (dossier):
        $dir = $this->get('upload_directory');

        // la fichier (.pdf,.doc,.docx,.word)
        $uploadedFile = $request->getUploadedFiles();

        // validation des donner :
        $validation = $this->validator->validateAll($request,['titre','resume','type','langue','domaine']);
        if(!$validation->valid()){
            // erreur
            return $response->withRedirect($this->router->pathFor('user'));
        }

        // validation de fichier :
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = moveUploadedFile($dir, $uploadedFile);
            $response->write('uploaded ' . $filename . '<br/>');
        }else{
            $this->flash->addMessage('errors', "Erreur l'ors d'upload de fichier , réessayer");
            return $response->withRedirect($this->router->pathFor('user'));
        }

        print_r($request->getParams());
        print_r($request->getUploadedFiles());
        return "nice";

    }
}