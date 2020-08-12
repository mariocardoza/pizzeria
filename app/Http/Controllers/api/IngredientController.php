<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ingredient;
use Auth;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allIngredients()
    {
        return Ingredient::whereEstado(1)->get();
    }
    public function index()
    {
        return Ingredient::whereEstado(1)->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ingredient=Ingredient::create([
            'nombre'=>$request->nombre,
            'precio'=>$request->precio,
        ]);
        return $ingredient;
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
        try{
            $ingredient=Ingredient::findorFail($id);
            $ingredient->fill($request->all());
            $ingredient->save();
            
            return $ingredient;
        }catch(Exception $e){
            return $e;
        }
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
            $ingredient=Ingredient::findorFail($id);
            $ingredient->estado=2;
            $ingredient->save();
            return $ingredient;
        }catch(Exception $e){
            return $e;
        }
    }
}
