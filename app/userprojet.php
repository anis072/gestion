<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userprojet extends Model
{
    //
    public $table = 'user_projet';
    protected $fillable = [
        'projet_id' , 'user_id','membre'
      ];
}

