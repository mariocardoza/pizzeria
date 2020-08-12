<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialityIngredient extends Model
{
    protected $guarded = [];

    public function ingredient()
    {
    	return $this->belongsTo('App\ingredient');
    }

    public function detallepizza()
    {
        return $this->belongsToMany('App\SpecialityIngredient','speciality_id');
    }
}
