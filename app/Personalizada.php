<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personalizada extends Model
{
    protected $guarded = [];

    public function masa()
    {
    	return $this->belongsTo('App\Masa');
    }

    public function tamanio()
    {
    	return $this->belongsTo('App\Tamanio');
    }

   public function detalles()
   {
   	return $this->hasMany('App\PersonalizadaDetail');
   }
}
