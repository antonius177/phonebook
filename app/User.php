<?php

namespace App;


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{	
	use Authenticatable, CanResetPassword;
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
        'name', 'email', 'password','admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	 public function contacts()
    {
        return $this->hasMany('App\Contact');
    }

    public function groups()
    {
        return $this->hasMany('App\Group');
    }
}
