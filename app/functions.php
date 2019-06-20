<?php
use Slim\Http\UploadedFile;
use App\Models\Document;

/*
 *  Fonction n°1 : generer une chaine de caractaire aliatoir
 *  taille 6 caractaire
 */

function randomString()
{
    $legnth = 6;
    $allChars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ$";
    $newString = substr(str_shuffle($allChars), 0, $legnth);
    return $newString;
}

/*
 *  Fonction n°2 : filter une chaine de catectaire (supprimer .)
 */
function filterString($val)
{
    $val = filter_var($val, FILTER_SANITIZE_STRING);
    return $val;
}

/*
 *  Fonction n°3 : generate url slug
 */
function slugGenerate($url)
{
    $regEx = '/[^\-\s\pN\pL]+/u';
    $url = preg_replace($regEx, '', mb_strtolower($url, 'UTF-8'));
    $regEx = '/[\-\s]+/';
    $url = preg_replace($regEx, '-', $url);
    return $url;
}

/*
 *  Fonction n°4 : remove url slug
 */
function slugRemove($url)
{
    $regEx = '/[\-\s]+/';
    $url = preg_replace($regEx, ' ', mb_strtolower($url, 'UTF-8'));
    return $url;
}

/*
 *  Fonction n°5 : déplacer la fichier téléchager( pfe ) + retourn le nv nom
 *                 de fichier
 */
function moveUploadedFile($directory, $ref, UploadedFile $uploadedFile)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    if ($ref == null) {
        $filename = date("Y-m-d") . randomString();
    } else {
        $filename  = date("Y-m-d-") . $ref;
    }
    $filename  = sprintf('%s.%0.8s', $filename, $extension);
    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}

/*
 *  Fonction n°6 : génere le reférance d'un doc passé sur leur info
 */
function genrateREF($lastId, $type, $fact, $depart)
{

    // année 2 caréctaire:
    $annee = date('y');

    // num département :
    $num_depart = str_pad($depart, 2, '0', STR_PAD_LEFT);

    // type de document :
    switch ($type) {
        case 1:
            $type = 'L';
            break;

        case 2:
            $type = 'M';
            break;

        case 3:
            $type = 'D';
            break;
    }

    // num séq :
    $lastId = (int)$lastId[0]->lastId == 0 ? 1 : (int)$lastId[0]->lastId;
    $num_seq = str_pad($lastId, 3, '0', STR_PAD_LEFT);
    return $annee . $type . $fact . $num_depart . $num_seq;
}

/*
 *  Fonction n°6 : creation de zip
 */

// function createZip($files, $zip , $dir)
// { 
//     $zip_name = date("Y-m-d") . ".zip";
//     if ($zip->open($zip_name , ZipArchive::CREATE) !== TRUE) {
//         // Erreur d'ovriteur de zip 
//         $this->flash->addMessage('errors', "Erreur vous pouvez pas télecharger l'archive");
//     }
//     $docs = Document::all();
//     foreach ($docs as $doc) {
//         $zip->addFile($dir . DIRECTORY_SEPARATOR . $doc->url);
//     }
//     // férmeture de zip object
//     $zip->close();

//     return $zip_name;
// }
