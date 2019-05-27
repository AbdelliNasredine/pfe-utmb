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
        'taille',
        'universite',
        'specialite',
        'date_publication',
        'url',
        'valid',
        'users_id',
        'categories_id',
        'sous_categories_id',
        'document_type_id'
    ];

    const CREATED_AT = 'date_publication';
    
    const UPDATED_AT = 'date_modification';



    /*  les relations */

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
    public function type(){

        return $this->belongsTo('App\Models\DocumentType','document_type_id');
    
    }
    public function evaluationGenerale(int $id) {

        return number_format( (float) Evaluation::where('documents_id' , $id)->avg('nb'), 1, '.', '') * 100 / 5;
    }
}