<?php
/*
**  configs.php contient :
**      {1}   configs d'affichage de msg ereur 
**      {2}   configs de connection db
**      {3}   list des lang supporter + lang par defaut
*/


// {1}
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

// {2}
$config['db']['host']   = 'localhost';
$config['db']['user']   = 'root';
$config['db']['pass']   = '1998Bechar';
$config['db']['dbname'] = 'pfe-utmb';

// {3}
// lang 'fr' par defaut 
$default_language = 'fr';
$available_languages = ['fr', 'ar', 'en'];


