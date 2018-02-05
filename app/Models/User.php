<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Notifications\Notifiable;
// use Kodeine\Acl\Traits\HasRole;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends BaseModel implements AuthenticatableContract, CanResetPasswordContract
{
    
    // use Authenticatable, CanResetPassword, HasRole, Notifiable;
    use Authenticatable, CanResetPassword, Notifiable;

    public function __construct() {
        
       
    }

    protected $table = 'users';


    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //notification for sk 11/01/17
    public function routeNotificationForMail()
    {
        return 'anmol.gupta@solutionplanets.com';
    }
}
