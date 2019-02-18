<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model{
   
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'pass',
        'type',
    ];

    public $timestamps = false;
    

}