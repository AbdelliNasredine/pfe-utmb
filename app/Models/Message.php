<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'nom',
        'email',
        'titre',
        'contenu',
        'date',
        'etat'
    ];

    public $timestamps = false;
}