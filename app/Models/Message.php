<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    protected $tabel ="messages";

    protected $fillable = [
        'nom',
        'email',
        'titre',
        'contenu',
        'date',
    ];

    public $timestamps = false;
}