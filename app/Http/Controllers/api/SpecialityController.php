<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PizzaSpecialitie;
use App\SpecialityIngredient;
use DB;
use Validator;

class SpecialityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allIngredients($id)
    {
        return SpecialityIngredient::where('Speciality_id',$id)->with('ingredient')->get();
    }

    public function getSpeciality($id)
    {
        //return PizzaSpecialitie::with(['tamanio','masa','ingredients'])->find($id);
        $retorno=PizzaSpecialitie::detalle_pizza($id);
        return $retorno;
    }

    public function allSpecialities()
    {
        return PizzaSpecialitie::whereEstado(1)->with(['tamanio','masa','ingredients'])->get();
    }
    public function index()
    {
        $pizzas=PizzaSpecialitie::whereEstado(1)->with(['tamanio','masa','ingredients'])->paginate(10);
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
            DB::beginTransaction();
            $pizza=PizzaSpecialitie::create([
                'nombre'=>$request->nombre,
                'precio'=>$request->precio,
                'masa_id'=>$request->masa,
                'tamanio_id'=>$request->size,
            ]);

            for($i=0;$i<count($request->ingredient);$i++){
                SpecialityIngredient::create([
                    'speciality_id'=>$pizza->id,
                    'ingredient_id'=>$request->ingredient[$i],
                ]);
            }
            DB::commit();
            return $pizza;
        }catch(Exception $e){
            DB::rollback();
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
            $pizza=PizzaSpecialitie::find($id);
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
