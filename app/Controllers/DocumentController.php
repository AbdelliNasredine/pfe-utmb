<?php

namespace App\Controllers;


use App\Models\Document;
use App\Models\SousCategorie;
use App\Models\Categorie;
use App\Models\Evaluation;
use App\Models\User;


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
        $document = Document::where('id', $id)->where('valid',true)->first();
        // test si le document n'existe pas
        if(!$document){
            // ERREUR
            return $this->view->render($response, '404.twig');
        }
        // le document existe
        // recupaire l'utilisateur qui ajoute se documents :
        $user = User::find((int) $document->user_id);
        // recupaire les evaluations
        $evals = Evaluation::where('documents_id',$document->id)->orderBy('date','desc')->get();
        // evaluation génerale :
        $evalGenerale = Evaluation::where('documents_id',$document->id)->avg('nb');
        $nbs  = $this->db::select('select  count(*) as total_per_nb , nb from evaluations where documents_id = :id group by nb'
                                    ,['id'=> $document->id]
                                );
        $total_par_nb = array();
        foreach( $nbs as $nb ){
            $total_par_nb[ $nb->nb ] = $nb->total_per_nb; 
        }
        //var_dump($total_par_nb);
        //die();
        $path = $this->language . DIRECTORY_SEPARATOR . 'document/document.twig';
        return $this->view->render($response, $path , [
            "document" => $document,
            "user" => $user,
            "evaluations" => $evals,
            "evaluationGenerale" => number_format( (float) $evalGenerale, 1, '.', ''),
            "evalParNb" => $total_par_nb,
            "totatNb" => count($evals)
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

        // validation de fichier :
        if( !empty($uploadedFile) ){
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $extention = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
                if(in_array($extention,['pdf','doc','word','docx'])){
                    // succée 
                    $filename = moveUploadedFile($dir, $uploadedFile);

                    // convertire au pdf :
                    // test si extensien != .pdf
                    if( $extention != 'pdf' ){
                        // en convertire la fichier
                        // var_dump('start /wait soffice --headless --convert-to pdf --oudir '.$dir.' '.$dir.DIRECTORY_SEPARATOR.$filename.'');
                        // die();
                        $chemin = $dir . DIRECTORY_SEPARATOR . $filename;
                        // var_dump($chemin);
                        // die();    
                        shell_exec('start /wait soffice -headless -convert-to pdf '.$chemin.' -outdir '.$dir );
                        // supprime la fichier orginall
                        unlink($dir . DIRECTORY_SEPARATOR . $filename) or die("ereur de suppression");
                        $ext = ['.word','.docx','.doc'];
                        $filename = str_replace($ext,".pdf",$filename);
                        // var_dump($filename);
                        // die();
                    }

                    // ajoute de document dans la base de donnée :
                    $sousCategorie = SousCategorie::find( (int) $request->getParam('domaine') );
                    $doc = Document::create([
                        'ref' => genrateREF($this->db::select('select MAX(id) AS lastId from documents'),$request->getParam('type')),
                        'auteur' => $request->getParam('auteur'),
                        'titre'  => $request->getParam('titre'),
                        'resume' => $request->getParam('resume'),
                        'type'   => $request->getParam('type'),
                        'langue' => $request->getParam('langue'), 
                        'universite' => $request->getParam('univ'),
                        'faculte' => $request->getParam('fact'),
                        'specialite' => $request->getParam('spes'),
                        'date_publication' => date("Y-m-d"),
                        'url' => $filename,
                        'valid' => false,
                        'user_id' => $this->auth->user()->id, 
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
        }else{
            // erreur : no fichier uploader / taille > 8 mega
            $this->flash->addMessage('errors', 'Erreur fichier supperiour à 20 méga, essayez autre');
            return $response->withRedirect($this->router->pathFor('user'));
        }
        $this->flash->addMessage('success', 'succeé ! votre document a été ajouter avec succée ');
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

    public function documentDetails($request , $response)
    {
        $id = (int) filter_var($request->getParam('id'),FILTER_VALIDATE_INT);

        $document = Document::find($id);

        if($document->type == 'l'){
            $type = "Mémoire licence";
        }else if($document->type == 'm'){
            $type = "Mémoire Master";
        }else if($document->type == 'd'){
            $type = "Thése doctorat";
        }else{
            $type = "Autre";
        }

        $details = '
        <div class="table-responsive">  
            <table class="table table-striped">
        ';

        $details .= '  
        <tr>  
             <td width="30%"><label class="font-weight-bold">Réference</label></td>  
             <td width="70%">'.$document->ref.'</td>  
        </tr>  
        <tr>  
             <td width="30%"><label class="font-weight-bold">Titre</label></td>  
             <td width="70%">'.$document->titre.'</td>  
        </tr>  
        <tr>  
             <td width="30%"><label class="font-weight-bold">Auteur</label></td>  
             <td width="70%">'.$document->auteur.'</td>  
        </tr>  
        <tr>  
             <td width="30%"><label class="font-weight-bold">Résume</label></td>  
             <td width="70%">'.$document->resume.'</td>  
        </tr> 
        <tr>  
             <td width="30%"><label class="font-weight-bold">Type de document</label></td>  
             <td width="70%">
                <span class="badge badge-info">
                '.$type.'
                </span>
             </td>  
        </tr>  
        <tr>  
             <td width="30%"><label class="font-weight-bold">Date de publication</label></td>  
             <td width="70%">'.$document->date_publication.'</td>  
        </tr>
        <tr>  
             <td width="30%"><label class="font-weight-bold">Université</label></td>  
             <td width="70%">'.$document->universite.'</td>  
        </tr>
        <tr>  
             <td width="30%"><label class="font-weight-bold">Faculté</label></td>  
             <td width="70%">'.$document->faculte.'</td>  
        </tr>
        <tr>  
             <td width="30%"><label class="font-weight-bold">Specialité</label></td>  
             <td width="70%">'.$document->specialite.'</td>  
        </tr>
        <tr>  
             <td width="30%"><label class="font-weight-bold">Ajouter par</label></td>  
             <td width="70%">'.User::find((int) $document->user_id)->email.'</td>  
        </tr>          
        ';

        $details .= '
            </table>
        </div>';
        echo $details;

    }
}