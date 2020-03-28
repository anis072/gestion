<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Projet;
class Task extends Model
{
    protected $appends = ["open"];
	public function getOpenAttribute(){
		return true;
    }
    public function project(){
        return $this->belongsTo(Projet::Class);
    }
}

    //

