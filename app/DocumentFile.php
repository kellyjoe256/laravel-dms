<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentFile extends Model
{
    // Table name
    protected $table = 'document_file';
    // Primary Key
    protected $primaryKey = 'file_id';

    public function document()
    {
        return $this->belongsTo('App\Document', 'document_id');
    }
}
