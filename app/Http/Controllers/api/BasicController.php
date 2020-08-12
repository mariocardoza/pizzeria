<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PizzaIngredient;
use Validator;
use DB;

class BasicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pizzas=PizzaIngredient::whereEstado(1)->with(['tamanio','masa','ingredient'])->paginate(10);
        return $pizzas;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validar($request->all())->validate();
        try{
            $pizza=PizzaIngredient::create([
                'nombre'=>$request->nombre,
                'precio'=>$request->precio,
                'masa_id'=>$request->masa,
                'tamanio_id'=>$request->size,
                'ingredient_id'=>$request->ingredient,
            ]);
            return $pizza;
        }catch(Exception $e){
            return $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $pizza=PizzaIngredient::find($id);
            $pizza->estado=2;
            $pizza->save();
            return $pizza;
        }catch(Exception $e){
            return $e;
        }
    }

    protected function validar(array $data)
    {
        $mensajes=array(
            'nombre.required'=>'El nombre es obligatorio',
            'precio.required'=>'El precio el obligatorio',
            'masa.required'=>'Debe seleccionar un tipo de masa',
            'size.required'=>'Debe seleccionar un tamaño de masa',
            'ingredient.required'=>'Debe seleccionar un ingrediente',
      );
      return Validator::make($data, [
          'nombre'=>'required',
          'precio'=>'required',
          'masa'=>'required',
          'size'=>'required',
          'ingredient'=>'required',

      ],$mensajes);
    }
}
