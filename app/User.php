<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function is_Admin(){
        if($this->role()->name == 'Admin') {
            return TRUE;
        }
        return FALSE;
    }


    public function role()
    {
        return $this->belongsTo('App\Role')->first();
    }
    
    public function photos() {
        return $this->hasMany('App\Photo');
    }
    
    public function avatar() {
        return $this->photos()->where('is_thumbnail','=', 1)->first();
    }
}
