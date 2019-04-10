<?php
/*
**  configs.php contient :
**      {1}   configs d'affichage de msg ereur
**      {2}   configs de base de donnée 'illuminate'
**      {3}   list des lang supporter + lang par defaut
*/


// {1}
$config['displayErrorDetails']      = true;
$config['addContentLengthHeader']   = false;

//{2}
$config['db']['driver']    = 'mysql';
$config['db']['host']      = 'localhost';
$config['db']['database']  = 'pfe_db';
$config['db']['username']  = 'root';
$config['db']['password']  = '';
$config['db']['charset']   = 'utf8';
$config['db']['collation'] = 'utf8_unicode_ci';
$config['db']['prefix']    = '';

// {3}
// lang 'fr' par defaut 
$default_language       = 'fr';
$available_languages    = ['fr', 'ar'];


