<?php
/*
 *  Fonction n°1 : generer une chaine de caractaire aliatoir
 *  taille 6 caractaire
 */
function randomString(){
    $legnth = 6;
    $allChars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ%_$";
    $newString = substr(str_shuffle($allChars),0,$legnth);
    return $newString;
}