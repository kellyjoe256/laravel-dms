<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    // Table name
    protected $table = 'department';
    // Primary Key
    protected $primaryKey = 'department_id';

    public function branches()
    {
        return $this->belongsToMany(
            'App\Branch',
            'branch_department',
            'department_id',
            'branch_id'
        );
    }

    public function users()
    {
        return $this->hasMany('App\User', 'department_id');
    }

    public function documents()
    {
        return $this->hasMany('App\Document', 'department_id');
    }
}
