<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{

    protected $table ="documents";

    protected $fillable = [
        'auteur',
        'titre',
        'resume',
        'langue',
        'faculte',
        'universite',
        'annee_publication',
        'domain',
        'nb_page',
        'evaluation_generale',
        'mots_cle',
        'categories_id',
        'sous_categories_id',
    ];

    public $timestamps = false;

    public function categorie()
    {
        return $this->belongsTo('\App\Models\Categorie','id');
    }

    public function souscategorie()
    {
        return $this->belongsTo('\App\Models\SousCategorie','id');
    }
    
}