<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderExtra extends Model
{
    protected $guarded = [];

    public function extra()
    {
    	return $this->belongsTo('App\Extra');
    }
}
