<?php
/*
 *  Fonction n°1 : generer une chaine de caractaire aliatoir
 *  taille 6 caractaire
 */

use Slim\Http\UploadedFile;
use App\Models\Document;

function randomString(){
    $legnth = 6;
    $allChars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ$";
    $newString = substr(str_shuffle($allChars),0,$legnth);
    return $newString;
}

/*
 *  Fonction n°2 : filter une chaine de catectaire (supprimer .)
 */
function filterString($val){
    $val = filter_var($val , FILTER_SANITIZE_STRING);
    return $val;
}
/*
 *  Fonction n°3 : generate url slug
 */
function slugGenerate($url){
    $regEx = '/[^\-\s\pN\pL]+/u';
    $url = preg_replace($regEx,'', mb_strtolower($url,'UTF-8'));
    $regEx = '/[\-\s]+/';
    $url = preg_replace($regEx , '-',$url);
    return $url;
}
/*
 *  Fonction n°4 : remove url slug
 */
function slugRemove($url){
    $regEx = '/[\-\s]+/';
    $url = preg_replace($regEx,' ', mb_strtolower($url,'UTF-8'));
    return $url;
}
/*
 *  Fonction n°5 : déplacer la fichier téléchager( pfe ) + retourn le nv nom
 *                 de fichier
 */
function moveUploadedFile($directory, UploadedFile $uploadedFile)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $filename  = date("Y-m-d-his-").randomString();
    $filename  = sprintf('%s.%0.8s', $filename, $extension);
    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}
/*
 *  Fonction n°6 : génere des coleur aliatoir 
 */
function randomColor()
{
    // 9 cls
    $colors = [
        "#cb2025",
        "#cb2098",
        "#8c20cb",
        "#206acb",
        "#5320cb",
        "#20cbcb",
        "#2ecb20",
        "#cbba20",
        "#cb7320",
    ];
    return $colors[ rand(0,8) ];
}

/*
 *  Fonction n°6 : génere le reférance d'un doc passé sur leur info
 */
function genrateREF($lastId , $type ){
    $lastId = (int) $lastId[0]->lastId;
    return strtoupper($type).$lastId."-".date("Ymdhis");
}