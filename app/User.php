<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Library\Hash;

class User extends Authenticatable
{
    use Notifiable;

    // Table name
    protected $table = 'user';
    // Primary Key
    protected $primaryKey = 'user_id';
    // Dates
    protected $dates = ['last_login',];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'passwd',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'passwd', 'remember_token',
    ];

    public function branch()
    {
        return $this->belongsTo('App\Branch', 'branch_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public function documents()
    {
        return $this->hasMany('App\Document', 'user_id');
    }

    public function checkCredentials($password)
    {
        $generated_password = Hash::make($password, $this->salt);
        // Check if generated password equals the stored password
        // and user is allowed to login
        return ($this->passwd == $generated_password) && $this->active;
    }
}
