<?php
/*
 *  Fonction n°1 : generer une chaine de caractaire aliatoir
 *  taille 6 caractaire
 */

use Slim\Http\UploadedFile;

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

