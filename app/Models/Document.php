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
        'type',
        'faculte',
        'universite',
        'annee_publication',
        'url',
        'categories_id',
        'sous_categories_id',
    ];

    public $timestamps = false;

    public function categorie()
    {
        return $this->belongsTo('\App\Models\Categorie','categories_id');
    }

    public function souscategorie()
    {
        return $this->belongsTo('\App\Models\SousCategorie','sous_categories_id');
    }
    
}