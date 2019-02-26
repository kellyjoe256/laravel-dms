<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentCategory extends Model
{
    // Table name
    protected $table = 'document_category';
    // Primary Key
    protected $primaryKey = 'category_id';

    public function documents()
    {
        return $this->hasMany('App\Document', 'category_id');
    }
}
