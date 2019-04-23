<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{

    protected  $table ="evaluations";

    protected $fillable = [
        'users_id',
        'documents_id',
        'contenu',
        'date',
        'nb'
    ];

    public $timestamps = false;

    public function user(){
        return $this->belongsTo('\App\Models\User','users_id');
    }
}