<?php

namespace App\Controllers;


use App\Models\Categorie;
use App\Models\Document;
use App\Models\SousCategorie;


class CategorieController extends BaseController
{
    public function getCategories($request, $response, array $args)
    {
        /*
         *  selon l'url on va faire le suivante :
         *  $args = array [ "categorieNom" => ? , "sousCategorieNom" => ?  ]
         *    si $args est vide (count($args == 0))
         *      - on affiche la page de 'TouT categorie avec sous categorie dispo'
         *    si $args taill est egale a 1 (count($args == 1))
         *      - on affiche la page de assosie avec "categorieNom"
         *    si $args taill est egale a 2 (count($args == 2))
         *      - on affiche la page de assosie avec "sousCategorieNom"
         *
         *      + Systém de pagination simple
         *      + Systém de filtrage (trie par ...) simple
        */
        switch (count($args)){
            case 0:
                $categories = Categorie::orderBy('nom')->get();
                $path = $this->language . DIRECTORY_SEPARATOR . 'categorie/categories.twig';
                return $this->view->render($response, $path, [
                    "lang" => $this->language,
                    "categories" => $categories
                ]);
                break;
            case 1:
                // la categorie :
                $categorieNom = filterString($args['categorieNom']);
                $categorieNom = slugRemove($categorieNom);
                $categorie = Categorie::where('nom', $categorieNom)->first();
                if (!$categorie) {
                    return $this->view->render($response, '404.twig');
                }
                // pagination :
                $page = $request->getParam('page');
                $limit = 5;
                $pageCourante = ( isset($page) AND !empty($page) AND $page > 0 )? intval($page) : 1;
                $total = $categorie->documents()->count();
                $depart = ($pageCourante - 1) * $limit;
                $nbPage = ceil($total / $limit);
                if($depart === 0){
                    $documents = $categorie->documents()->limit($limit)->get();
                } else{
                    $documents = $categorie->documents()->skip($depart)->take($limit)->get();
                }
                // Erreur (categorie ou page erronée n'existe pas)
                if (!$categorie ) {
                    return $this->view->render($response, '404.twig');
                }
                $path = $this->language . DIRECTORY_SEPARATOR . 'categorie/categorie.twig';
                return $this->view->render($response, $path, [
                    "lang" => $this->language,
                    "categorie"  => $categorie,
                    "documents"  => $documents,
                    "total" => $total,
                    "nombrePage" => $nbPage,
                    "pageCourante" => $pageCourante,
                ]);
                break;
            case 2:
                // la categorie :
                $categorieNom = filterString($args['categorieNom']);
                $categorieNom = slugRemove($categorieNom);
                $categorie = Categorie::where('nom', $categorieNom)->first();
                // la sous categorie :
                $sousCategorieNom = filterString($args['sousCategorieNom']);
                $sousCategorieNom = slugRemove($sousCategorieNom);
                $sousCategorie = SousCategorie::where('nom',$sousCategorieNom)->first();
                // pagination :
                $page = $request->getParam('page');
                $limit = 5;
                $pageCourante = ( isset($page) AND !empty($page) AND $page > 0 )? intval($page) : 1;
                $total = $sousCategorie->documents()->count();
                $depart = ($pageCourante - 1) * $limit;
                $nbPage = ceil($total / $limit);
                if($depart === 0){
                    $documents = $sousCategorie->documents()->limit($limit)->get();
                } else{
                    $documents = $sousCategorie->documents()->skip($depart)->take($limit)->get();
                }
                // Erreur (categorie ou sous categorie  ou page erronée n'existe pas)
                if (!$categorie OR !$sousCategorie ) {
                    return $this->view->render($response, '404.twig');
                }
                $path = $this->language . DIRECTORY_SEPARATOR . 'categorie/categorie.twig';
                return $this->view->render($response, $path, [
                    "lang" => $this->language,
                    "categorie"  => $categorie,
                    "sousCategorie" => $sousCategorie,
                    "documents"  => $documents,
                    "total" => $total,
                    "nombrePage" => $nbPage,
                    "pageCourante" => $pageCourante,
                ]);
                return "categorie/categorie-nom/sous-categorie-nom";
                break;
        }
    }

}