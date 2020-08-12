<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $guarded = [];

    public function pizzas()
    {
    	return $this->belongsTo('App\PizzaSpecialitie','pizza_id');
    }
}
