<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $table = "categories";

    protected $fillable = [
        'nom'
    ];

    public $timestamps = false;

    public function souscategories()
    {
        return $this->hasMany('App\Models\SousCategorie','categorie_id');
    }
    public function documents()
    {
        return $this->hasMany('App\Models\Document','categories_id');
    }
}