<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail2 extends Model
{
    protected $guarded = [];

    public function pizzas()
    {
    	return $this->belongsTo('App\PizzaIngredient','pizza_id');
    }
}
