<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    //
    use HasApiTokens, Notifiable;
       protected $fillable = [
        'id','name', 'email', 'password','tel'
    ];
    public function projets(){
        return $this->hasMany(Projet::class);
    }
}
