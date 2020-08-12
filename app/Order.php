<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    protected $dates = ['updated_at'];

    public function details()
    {
    	return $this->hasMany('App\OrderDetail');
    }

    public function details2()
    {
    	return $this->hasMany('App\OrderDetail2');
    }

    public function extras()
    {
    	return $this->hasMany('App\OrderExtra');
    }

    public static function correlativo()
    {
        $numero=Order::where('estado',2)->count();
        return $numero+1;  
    }

    public static function carrito($token)
    {
    	$html="";
    	$eltotal=0;
    	$html.='<div class="col-sm-12"><h2>Carrito de compras</h2></div>';
    	$orden=Order::where('token',$token)->whereEstado(1)->first();
    	if($orden!=''):
    	$eltotal=$orden->total;
    	endif;
    	$html.='<div class="col-sm-12"><span class="float-right"><b style="font-size:20px;">Total: $'.number_format($eltotal,2).'</b></span></div><br>';
    	if($orden!=''):
    	foreach($orden->details as $d){
    		$html.='<div class="col-sm-12"><span class="float-left"><b>'.$d->pizzas->nombre.'</b></span><span class="float-right"><b>$'.number_format($d->pizzas->precio,2).'</b></span>&nbsp; <a class="quitar_especialidad" data-precio="'.$d->pizzas->precio.'" data-order="'.$d->id.'" data-id="'.$orden->id.'" href="javascript:void(0)"><i style="color:red;" class="fas fa-trash"></i></a></div>';
    		$html.='<div class="col-sm-12"><ul>';
    		foreach($d->pizzas->ingredients as $i){
    			$html.='<li>'.$i->ingredient->nombre.'</li>';
    		}
    		$html.='</ul></div>';
    	}
    	
    	foreach($orden->details2 as $d2){
    		$html.='<div class="col-sm-12"><span class="float-left"><b>'.$d2->pizzas->nombre.'</b></span><span class="float-right"><b>$'.number_format($d2->pizzas->precio,2).'</b></span> &nbsp;<a class="quitar_basica" data-precio="'.$d2->pizzas->precio.'" data-order="'.$d2->id.'" data-id="'.$orden->id.'" href="javascript:void(0)"><i style="color:red;" class="fas fa-trash"></i></a></div>';
    		$html.='<div class="col-sm-12"><ul>';
    		//foreach($d->pizzas->ingredients as $i){
    			$html.='<li>'.$d2->pizzas->ingredient->nombre.'</li>';
    		//}
    		$html.='</ul></div>';
    	}
    	foreach($orden->extras as $e){
    		$html.='<div class="col-sm-12"><span class="float-left"><b>'.$e->extra->nombre.'</b></span><span class="float-right"><b>$'.number_format($e->extra->precio,2).'</b></span> &nbsp;<a class="quitar_extra" data-precio="'.$e->extra->precio.'" data-extra="'.$e->id.'" data-id="'.$orden->id.'" href="javascript:void(0)"><i style="color:red;" class="fas fa-trash"></i></a></div>';
    		$html.='<div class="col-sm-12">';
    		//foreach($d->pizzas->ingredients as $i){
    			//$html.='<li>'.$d2->pizzas->ingredient->nombre.'</li>';
    		//}
    		$html.='</div>';
    	}
        $html.='<br><div class="col-sm-12">
            <button class="btn btn-info ordenar" data-id="'.$orden->id.'" type="button">Confirmar</button>
        </div>';
    	endif;
    	
    	return array(1,"exito",$html);
    }

    public static function contar_carrito($token)
    {
    	$orden=Order::whereToken($token)->whereEstado(1)->first();
    	if($orden){
    		$cuantos=0;
	    	$cuantos1=$orden->details->count();
	    	$cuantos2=$orden->details2->count();
	    	$cuantos3=$orden->extras->count();
	    	$cuantos=$cuantos1+$cuantos2+$cuantos3;
	    	return $cuantos;
	    }else{
	    	return 0;
	    }
    }
}
