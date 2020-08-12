<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PizzaIngredient;
use App\PizzaSpecialitie;
use App\Extra;
use App\Order;

class OrdenController extends Controller
{
    public function index()
    {
    	$pizzas=PizzaIngredient::whereEstado(1)->get();
    	$especialidades=PizzaSpecialitie::whereEstado(1)->get();
    	$extras=Extra::whereEstado(1)->get();
    	return view('orden.orden',compact('pizzas','especialidades','extras'));
    }

    public function pedidos()
    {
        $pedidos=Order::whereEstado(2)->where('email',Auth()->user()->email)->get();
    	return view('orden.pedidos',compact('pedidos'));
    }

    public function login()
    {
    	return view('orden.login');
    }
    public function registrar()
    {
    	return view('orden.registrar');
    }

    public function pdf($id)
    {
        $orden=Order::find($id);
        $pdf = \PDF::loadView('orden.pdf',compact('orden'));
        $customPaper = array(0,0,360,360);
        //$pdf->setPaper($customPaper);
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('pedido.pdf');
    }
}
