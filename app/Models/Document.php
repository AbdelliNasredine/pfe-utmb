<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{

    protected $table ="documents";

    protected $fillable = [
        'ref',
        'auteur',
        'titre',
        'resume',
        'langue',
        'type',
        'universite',
        'faculte',
        'specialite',
        'date_publication',
        'url',
        'valid',
        'user_id',
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
    public function evaluations()
    {
        return $this->hasMany('\App\Models\Evaluation','documents_id');
    }
    public function evaluationGenerale(int $id) {

        return number_format( (float) Evaluation::where('documents_id' , $id)->avg('nb'), 1, '.', '') * 100 / 5;
    }
}