<?php

namespace App\Controllers;


use App\Models\Categorie;
use App\Models\Document;

class RechercheController extends BaseController
{
    /* méthod d'affichage de page de recherche */
    public function index($request, $response)
    {
        $searchword = filter_var($request->getParam('q'), FILTER_SANITIZE_STRING);
        //recupaire la liste des document ou le titre est comme $queryString
        $documents = Document::where('titre', 'LIKE', "%$searchword%");

        // si un filter est mit (lang ou catgeorie)
        if(!empty($request->getParam('cat'))){
            $catNom = filter_var($request->getParam('cat'),FILTER_SANITIZE_STRING);
            $catId = Categorie::where('nom',$catNom)->first()->id;
        }
        // recupaire la liste des categories :
        $categories = Categorie::all();
        $path = $this->language . DIRECTORY_SEPARATOR . 'search.view.twig';
        return $this->view->render($response, $path, [
            "lang" => $this->language,
            "categories" => $categories,
            "documents" => $documents->get(),
            "searchWord" => $searchword
        ]);
    }
}