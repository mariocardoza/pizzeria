<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzaIngredient extends Model
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

    public function ingredient()
    {
    	return $this->belongsTo('App\Ingredient');
    }
}
