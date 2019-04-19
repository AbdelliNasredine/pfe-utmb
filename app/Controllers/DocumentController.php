<?php

namespace App\Controllers;


use App\Models\Document;
use App\Models\SousCategorie;
use App\Models\Categorie;

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
        $dir = $this->container->get('upload_directory');


        // la fichier (.pdf,.doc,.docx,.word)
        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['doc'];
        var_dump($uploadedFiles->getSize());
        die();

        // validation des donner :
        $validation = $this->validator->validateAll($request,['titre','resume','type','langue','domaine']);
        if(!$validation->valid()){
            // erreur
            return $response->withRedirect($this->router->pathFor('user'));
        }

        // validation de fichier :
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $extention = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
            if(in_array($extention,['pdf','doc','word','docx'])){
                // succée 
                $filename = moveUploadedFile($dir, $uploadedFile);

                // ajoute de document dans la base de donnée :
                $sousCategorie = SousCategorie::find( (int) $request->getParam('domaine') );
                Document::create([
                    'auteur' => $this->auth->user()->nom.' '.$this->auth->user()->prenom,
                    'titre'  => $request->getParam('titre'),
                    'resume' => $request->getParam('resume'),
                    'type'   => $request->getParam('type'),
                    'langue' => $request->getParam('langue'), 
                    'annee_publication' => date("Y-m-d"),
                    'url' => $filename,
                    'categories_id' => $sousCategorie->categorie_id,
                    'sous_categories_id' => $sousCategorie->id,   
                ]);


            }else{
                // erreur : extention erronner != '.pdf','.doc','.word','.docx'
                $this->flash->addMessage('errors', "veullez choisire une fichier .pdf , .doc , .docx , .word");
                return $response->withRedirect($this->router->pathFor('user'));
            }
        }else{
            // erreur : fichier pas uploader
            $this->flash->addMessage('errors', "Erreur l'ors d'upload de fichier , réessayer");
            return $response->withRedirect($this->router->pathFor('user'));
        }

        $this->flash->addMessage('success', 'votre pfe a été ajouter avec succée');
        return $response->withRedirect($this->router->pathFor('user'));

    }

    public function downloadDocument($request , $response , array $args)
    {
        /*
         * cette méthod pérmet le téléchargement d'un document
         *  pfe         
        */

        // recupaire le document dans le serveur (chemain) :
        $doc = Document::where('url',(string) $args['url'])->first();

        // test si le document est trouvez
        if(!$doc){
            // erreur : doc no trouvez dans le serveur
            return $this->view->render($response, '404.twig');
        }

        $file = $this->container->get('upload_directory') . DIRECTORY_SEPARATOR . $doc->url;
        
        $fh = fopen($file, 'rb');

        $stream = new \Slim\Http\Stream($fh); 

        return $response->withHeader('Content-Type', 'application/force-download')
                        ->withHeader('Content-Type', 'application/octet-stream')
                        ->withHeader('Content-Type', 'application/download')
                        ->withHeader('Content-Description', 'File Transfer')
                        ->withHeader('Content-Transfer-Encoding', 'binary')
                        ->withHeader('Content-Disposition', 'attachment; filename="' . basename($file) . '"')
                        ->withHeader('Expires', '0')
                        ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
                        ->withHeader('Pragma', 'public')
                        ->withBody($stream);        

    }
}