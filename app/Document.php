<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    // Table name
    protected $table = 'document';
    // Primary Key
    protected $primaryKey = 'document_id';
    // Dates
    protected $dates = ['creation_date',];

    public function category()
    {
        return $this->belongsTo('App\DocumentCategory', 'category_id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch', 'branch_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function files()
    {
        return $this->hasMany('App\DocumentFile', 'document_id');
    }
}
