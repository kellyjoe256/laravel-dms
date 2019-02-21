<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    // Table name
    protected $table = 'branch';
    // Primary Key
    protected $primaryKey = 'branch_id';

    public function departments()
    {
        return $this->belongsToMany(
            'App\Department',
            'branch_department',
            'branch_id',
            'department_id'
        );
    }

    public function users()
    {
        return $this->hasMany('App\User', 'branch_id');
    }

    public function documents()
    {
        return $this->hasMany('App\Document', 'branch_id');
    }
}
