<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SousCategorie extends  Model
{

    protected  $table = 'sous_categories';

    protected $fillable = [
        'nom',
        'categorie_id',
        'code'
    ];

    public $timestamps = false;

    public function categorie(){
        return $this->belongsTo('\App\Models\Categorie','categorie_id');
    }

    public function documents()
    {
        return $this->hasMany('App\Models\Document','sous_categories_id');
    }

}