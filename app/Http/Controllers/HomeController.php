<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth()->user()->tipo==1):
            $pedidos=\App\Order::whereEstado(2)->orderBy('updated_at','asc')->get();
            $frecuentes=DB::table('orders as r')
            ->select('r.nombre','r.email',DB::raw('count(r.email) AS veces'))
            ->where('r.estado','=',2)
            ->groupBy('r.email','r.nombre')
            ->orderBy('veces','DESC')
            ->get();
            $especialidades=DB::table('order_details as r')
            ->select('p.nombre',DB::raw('count(r.pizza_id) AS veces'))
            ->join('pizza_specialities as p','p.id','=','r.pizza_id','inner')
            ->groupBy('p.nombre')
            ->orderBy('veces','DESC')
            ->get();
            return view('home',compact('pedidos','frecuentes','especialidades'));
        else:
            
            return redirect('orden');
        endif;
    }
}
