<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class Admin extends Authenticatable
{
    //
    use Notifiable;
    use HasRolesAndAbilities;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'admins'; //表名

    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
