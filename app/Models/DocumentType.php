<?php   

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $table ="document_type";

    protected $fillable = [
        'doc_type'  
    ];

    public function documents() 
    {
        return $this->hasMany('App\Models\Document');
    } 
}
