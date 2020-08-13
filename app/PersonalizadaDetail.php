<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalizadaDetail extends Model
{
    protected $guarded = [];

     public function ingredient()
    {
    	return $this->belongsTo('App\Ingredient');
    }
}
