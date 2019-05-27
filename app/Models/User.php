<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected  $table ="users";

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'date_modification',
        'date_inscription',
        'profile_img',
        'user_types_id',
        'etat',
    ];

    const CREATED_AT = 'date_inscription';
    
    const UPDATED_AT = 'date_modification';

    /* les relations */

    public function type()
    {
        return $this->belongsTo('App\Models\UserType','user_types_id');
    }

    public function documents()
    {
        return $this->hasMany('\App\Models\Document','users_id');
    }
    
}