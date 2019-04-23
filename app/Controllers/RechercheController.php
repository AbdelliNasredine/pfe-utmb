<?php

namespace App\Controllers;


use App\Models\Categorie;
use App\Models\Document;

class RechercheController extends BaseController
{
    /* méthod d'affichage de page de recherche */
    public function index($request, $response )
    {

        // recupaire la liste des categories :
        $categories = Categorie::all();
        $path = $this->language . DIRECTORY_SEPARATOR . 'search.view.twig';
        return $this->view->render($response, $path, [
            "lang" => $this->language,
            "categories" => $categories,
        ]);  
        
    }

    /*
    *  méthod de traitage de recherche simple (mot clés ou référence)
    */
    public function simpleSearch($request,$response, array $args){
        // pour sans refreshe 'ajax'
        // recupaire les documents 
        // filtrage de searche word (security)
        $searchWord = filter_var($args['word'],FILTER_SANITIZE_STRING);

        // recherche par titre/réferance (simple) :
        $results = Document::where('titre','LIKE',"%$searchWord%")
                            ->where('valid',true)
                            ->orWhere('ref',$searchWord)
                            ->where('valid',true);
        // resultats vide
        if(!$results){
            // oui
            // séparation de mot complet a des mot clés : 
            $mots = explode(' ',$searchWord);
            $i = 1;
            $results = null;
            foreach( $mots as $mot ){
                if( $i=1 ){
                    $results = Document::where('titre','LIKE',"%$mot%")
                                        ->where('valid',true)
                                        ->orWhere('resume','LIKE',"%$mot%")
                                        ->where('valid',true);
                }else{
                    $results->orWhere('titre','LIKE',"%$mot%")
                            ->orWhere('resume','LIKE',"%$mot%");
                }
                $i++;
            }
            $results = $results == null ? [] : $results->get();
            return $response->withJson($results);
        }  
        
        return $response->withJson($results->get());
    }

    /*
    *  méthod de traitage de recherche simple
    */
    public function advanceSearch($request,$response){
        // le donnée recupairer (de recherche)
        $titre = filter_var($request->getParam('titre'),FILTER_SANITIZE_STRING);
        $type = filter_var($request->getParam('type'),FILTER_SANITIZE_STRING);
        $lang = filter_var($request->getParam('lang'),FILTER_SANITIZE_STRING);
        $domaine = filter_var($request->getParam('domaine'),FILTER_SANITIZE_STRING);
        $annee = filter_var($request->getParam('annee'),FILTER_SANITIZE_STRING);

        // recupaire les documents par titre 
        $resultats = Document::where('titre','LIKE',"%$titre%")
                                ->where('valid',true);
        
        if(!empty($type)){
            $resultats->where('type',$type);
        }
        if(!empty($lang)){
            $resultats->where('langue',$lang);
        }
        if(!empty($domaine)){
            $resultats->where('sous_categories_id',(int) $domaine);
        }
        if(!empty($annee)){
            $resultats->where('date_publication','LIKE',"%$annee%");
        }

        // renvoi les resultas
        $resultats = $resultats == null ? [] : $resultats->get();
        return $response->withJson($resultats);

    }
}