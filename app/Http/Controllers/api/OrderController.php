<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\OrderDetail;
use App\OrderDetail2;
use App\OrderExtra;
use DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPending($token)
    {
        //$orden=Order::whereEstado(1)->with('details')->first();
        //$pizzas=OrderDetail::where('order_id',$orden->id)->with(['pizzas'])->get();
        $retorno=Order::carrito($token);
        return $retorno;
    }
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $count=Order::whereToken($request->token)->whereEstado(1)->first();
            if($count!=''){
                if($request->tipo==1):
                    DB::beginTransaction();
                    $order=Order::findorFail($count->id);
                    $total=$order->total;
                    $t=$total+$request->total;
                    $order->total=$t;
                    $order->save();

                    $detalle=OrderDetail::create([
                        'order_id'=>$order->id,
                        'cantidad'=>$request->cantidad,
                        'pizza_id'=>$request->id_pizza,
                    ]);
                elseif($request->tipo==2):
                    $order=Order::findorFail($count->id);
                    $total=$order->total;
                    $t=$total+$request->precio;
                    $order->total=$t;
                    $order->save();

                    $detalle=OrderDetail2::create([
                        'order_id'=>$order->id,
                        'cantidad'=>$request->cantidad,
                        'pizza_id'=>$request->id_pizza,
                    ]);
                else:
                    $order=Order::findorFail($count->id);
                    $total=$order->total;
                    $t=$total+$request->precio;
                    $order->total=$t;
                    $order->save();

                    $detalle=OrderExtra::create([
                        'order_id'=>$order->id,
                        'extra_id'=>$request->id_extra,
                    ]);
                endif;
            }else{
                if($request->tipo==1):
                    $order=Order::create([
                        'tipo'=>$request->tipo,
                        'total'=>$request->precio,
                        'token'=>$request->token,
                    ]);

                    $detalle=OrderDetail::create([
                        'order_id'=>$order->id,
                        'cantidad'=>$request->cantidad,
                        'pizza_id'=>$request->id_pizza,
                    ]);
                elseif($request->tipo==2):
                    $order=Order::create([
                        'tipo'=>$request->tipo,
                        'total'=>$request->precio,
                        'token'=>$request->token,
                    ]);

                    $detalle=OrderDetail2::create([
                        'order_id'=>$order->id,
                        'cantidad'=>$request->cantidad,
                        'pizza_id'=>$request->id_pizza,
                    ]);
                else:
                    $order=Order::create([
                        'tipo'=>$request->tipo,
                        'total'=>$request->precio,
                        'token'=>$request->token,
                    ]);

                    $detalle=OrderExtra::create([
                        'order_id'=>$order->id,
                        'extra_id'=>$request->id_extra,
                    ]);
                endif;
            }
            $cuantos=Order::contar_carrito($request->token);
            DB::commit();
            return array(1,$cuantos);
        }catch(Exception $e){
            DB::rollback();
            return array(-1,"error",$e->getMessage());
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
    public function destroy($id,Request $request)
    {
        try{
            DB::beginTransaction();

            $orden=Order::find($id);
            $total=$orden->total;
            $precio=$request->precio;
            $orden->total=$total-$precio;
            $orden->save();
            $detail=OrderDetail::find($request->id_order);
            $detail->delete();
            $cuantos=Order::contar_carrito($request->token);
            if($cuantos==0){
                $orden->delete();
            }
            DB::commit();
            return array(1,$cuantos);
        }catch(Exception $e){
            DB::rollback();
            return array(-1,"error",$e->getMessage());
        }
    }

    public function delete2($id,Request $request)
    {
        try{
            DB::beginTransaction();
            $orden=Order::find($id);
            $total=$orden->total;
            $precio=$request->precio;
            $orden->total=$total-$precio;
            $orden->save();
            $detail=OrderDetail2::find($request->id_order);
            $detail->delete();
            $cuantos=Order::contar_carrito($request->token);
            if($cuantos==0){
                $orden->delete();
            }
            DB::commit();
            return array(1,$cuantos);
        }catch(Exception $e){
            DB::rollback();
            return array(-1,"error",$e->getMessage());
        }
    }
     public function delete3($id,Request $request)
    {
        try{
            DB::beginTransaction();
            $orden=Order::find($id);
            $total=$orden->total;
            $precio=$request->precio;
            $orden->total=$total-$precio;
            $orden->save();
            $detail=OrderExtra::find($request->id_extra);
            $detail->delete();
            $cuantos=Order::contar_carrito($request->token);
            if($cuantos==0){
                $orden->delete();
            }
            DB::commit();
            return array(1,$cuantos);
        }catch(Exception $e){
            DB::rollback();
            return array(-1,"error",$e->getMessage());
        }
    }

    public function confirmar($id,Request $request)
    {
        try{
            $orden=Order::find($id);
            $orden->nombre=$request->nombre;
            $orden->direccion=$request->direccion;
            $orden->telefono=$request->telefono;
            $orden->email=$request->email;
            $orden->estado=2;
            $orden->correlativo=Order::correlativo();
            $orden->save();
            return array(1,$orden);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }
}
