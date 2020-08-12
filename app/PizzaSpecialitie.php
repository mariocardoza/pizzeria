<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzaSpecialitie extends Model
{
    protected $guarded = [];

    public function ingredients()
    {
    	return $this->hasMany('App\SpecialityIngredient','speciality_id');
    }

    public function masa()
    {
    	return $this->belongsTo('App\Masa');
    }

    public function tamanio()
    {
    	return $this->belongsTo('App\Tamanio');
    }

    public static function detalle_pizza($id)
    {
        $pizza=PizzaSpecialitie::find($id);
        $html='<div class="col-sm-12"><span>'.$pizza->nombre.'</span></div>';
        $html.='<div class="col-sm-12"><ul>';
        foreach ($pizza->ingredients as $i) {
            $html.='<li>'.$i->ingredient->nombre.'</li>';
        }
        $html.='</ul></div>';
        $html.='<div class="col-sm-12">
                <button class="btn btn-info addEspecialidad" data-precio="'.$pizza->precio.'" data-id="'.$pizza->id.'">Agregar</button>
                <button class="btn btn-danger cancelar_orden">Cancelar</button>
            </div>';
        return array(1,"exito",$html);
    }

    
}


