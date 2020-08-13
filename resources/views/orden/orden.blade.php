@extends('layouts.orden')
@section('content')
<?php 
if(Auth()->user() !=''):
	$eltoken=Auth()->user()->eltoken;
else:
	$eltoken=csrf_token();
endif;
?>
<div class="container-fluid">
    <div class="row">
		<div class="col-md-12">
			<div class="card card-info">
				<div class="card-header">
					Orden de pizza
				</div>
					Seleccione
					<div class="row orden">
						<div class="col-md-3">
							<div class="card" >
					  
							  <div class="card-body">
							    <h5 class="card-title">Arma tu pizza</h5>
							    <img class="card-img-top" src="images/suprema.jpg" width="40" height="130" alt="Card image cap">
							    <button class="btn btn-info personalizar">Personalizar</button>
							    <span class="float-right">Desde $6.99</span>
							  </div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="card" >
					  
							  <div class="card-body">
							    <h5 class="card-title">Pizza de Especialidad</h5>
							    <img class="card-img-top" src="images/suprema.jpg" width="40" height="130" alt="Card image cap">
							    <button class="btn btn-info especialidad">Ordenar</button>
							    <span class="float-right">$16.99</span>
							  </div>
							</div>
						</div>
						@foreach($pizzas as $p)
						<div class="col-md-3">
							<div class="card" >
					  
							  <div class="card-body">
							    <h5 class="card-title">{{$p->nombre}}</h5>
							    <img class="card-img-top" src="images/pizza.jpg" width="40" height="130" alt="Card image cap">
							    <a href="javascript:void(0)" class="btn btn-info basica" data-precio="{{$p->precio}}" data-id="{{$p->id}}">Ordenar</a>
							    <span class="float-right">${{number_format($p->precio,2)}}</span>
							  </div>
							</div>
						</div>
						@endforeach
						<div class="col-md-3">
							<div class="card" >
					  
							  <div class="card-body">
							    <h5 class="card-title">Extras</h5>
							    <img class="card-img-top" src="images/panajo.jpg" width="40" height="130" alt="Card image cap">
							    <button class="btn btn-info especialidad">Ordenar</button>
							    <span class="float-right"></span>
							  </div>
							</div>
						</div>
					</div>
					<div class="row agregar" style="display: none;">
						<div class="card card-info col-md-6">
							<div class="card-header">
								Seleccione la especialidad
							</div>
							<div class="card-body">
								<div class="row">
									<select name="" class="form-control especialites">
										<option value="">Seleccionar</option>
										@foreach($especialidades as $e)
											<option value="{{$e->id}}">{{$e->nombre}} {{$e->tamanio->nombre}}</option>
										@endforeach
									</select>
								</div>
									
								
								<div class="row detalle_especialidad" >
									<div class="col-sm-12">
										<button class="btn btn-danger cancelar_orden">Cancelar</button>
									</div>
								</div>
									
									
							
							</div>
						</div>
						<div class="card card-info col-md-6">
							<div class="card-header">
								Extras
							</div>
							<div class="card-body ">
								<div class="row">
									<select name="" class="form-control sel_extra">
										<option value="">Seleccionar</option>
										@foreach($extras as $e)
											<option data-precio="{{$e->precio}}" value="{{$e->id}}">{{$e->nombre}} ${{$e->precio}}</option>
										@endforeach
									</select>
								</div>
									<br>
								
								<div class="row " >
									<div class="col-sm-12">
										<button class="btn btn-info addExtra">Agregar</button>
										<button class="btn btn-danger cancelar_orden">Cancelar</button>
									</div>
								</div>
							</div>
						</div>
						
					</div>
					<div class="row armar" style="display: none;">
						<div class="col-sm-8">
							<div class="card card-info">
							<div class="card-header">
								Personalizar
							</div>
							<div class="card-body">
								<div class="row " >
									<div class="col-sm-6">
										Seleccione las porciones
										<select name="" id="" class="form-control sel_tamanio">
											<option value="">Tamaño</option>
										@foreach($tamanios as $e)
											<option data-precio="{{$e->precio}}" value="{{$e->id}}">{{$e->nombre}} ${{$e->precio}}</option>
										@endforeach
										</select>
									</div>
									<div class="col-sm-6">
										Seleccione la masa
										<select disabled="" name="" id="" class="form-control sel_masa">
											<option value="">Seleccione</option>
										@foreach($masas as $e)
											<option data-precio="{{$e->precio}}" value="{{$e->id}}">{{$e->nombre}} ${{$e->precio}}</option>
										@endforeach
										</select>
									</div>
									<div class="col-sm-10">
										Seleccione los ingredientes
										<select disabled="" name="" id="" class="form-control sel_ingre">
											<option value="">Seleccione</option>
											@foreach($ingredientes as $e)
												<option data-precio="{{$e->precio}}" value="{{$e->id}}">{{$e->nombre}} ${{$e->precio}}</option>
											@endforeach
										</select>
									</div>
									<div class="col-sm-2">
										<button disabled="" class="btn btn-info anadir">Añadir</button>
									</div>
									<br><br><br>
									<div class="col-sm-12">
										<ul class="losingres">
										</ul>
										<h4 class="eltotal">$0.00</h4>
									</div>
									<br><br><br>
									<div class="col-sm-12">
										<button class="btn btn-info addPersonalizada">Agregar</button>
										<button class="btn btn-danger cancelar_orden">Cancelar</button>
									</div>
								</div>
							</div>
						</div>
						</div>
					</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal_ordenar" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 class="modal-title " id="exampleModalLabel">Confirmar información para el pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_confirmar">
          <div class="form-group">
            <label for="" class="control-label">Nombre completo</label>
            @if(Auth()->user())
            <input type="text" class="form-control" value="{{Auth()->user()->name}}" name="nombre" autocomplete="off" placeholder="Digite el nombre completo">
            @else
            <input type="text" class="form-control" name="nombre" autocomplete="off" placeholder="Digite el nombre completo">
            @endif
            
          </div>
          <div class="form-group">
            <label for="" class="control-label">Correo electrónico</label>
            @if(Auth()->user())
            <input type="text" class="form-control" value="{{Auth()->user()->email}}" name="email" autocomplete="off" placeholder="Digite el correo">
            @else
            <input type="text" class="form-control"  name="email" autocomplete="off" placeholder="Digite el correo">
            @endif
          </div>
          <div class="form-group">
            <label for="" class="control-label">Teléfono</label>
            <input type="text" class="form-control" name="telefono" autocomplete="off" placeholder="Digite la placa">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Dirección</label>
            <textarea name="direccion" id=""  rows="2" class="form-control"></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <div class="float-none"><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success finalizar_pedido">Finalizar pedido</button></div>
      </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
	const token='<?php echo $eltoken; ?>';
	let totalito=0;
	
	localStorage.setItem('token', token);
	$(document).ready(function(e){
		//cargar las del carrito
		
		pendientes();
		//evento click para pizzas de especialidad
		$(document).on("click",".especialidad",function(e){
			e.preventDefault();
			$(".agregar").show();
			$(".orden").hide();
		});
		$(document).on("click",".personalizar",function(e){
			e.preventDefault();
			$(".armar").show();
			$(".orden").hide();
		});
		//change para el tamaño
		$(document).on("change",".sel_tamanio",function(e){
			e.preventDefault();
			let t=$(".sel_tamanio").val();
			if(t!=''){
				$(".sel_masa").prop("disabled",false);
				totalito=0;
				let texto=$(".sel_tamanio option:selected").text();
				let precio=parseFloat($(".sel_tamanio option:selected").attr('data-precio'));
				totalito=totalito+precio;
				$(".eltotal").text("$"+totalito.toFixed(2));
			}
		});

		$(document).on("change",".sel_masa",function(e){
			e.preventDefault();
			let t=$(".sel_masa").val();
			if(t!=''){
				$(".sel_ingre").prop("disabled",false);
				$(".anadir").prop("disabled",false);
				let precio=parseFloat($(".sel_masa option:selected").attr('data-precio'));
				totalito=totalito+precio;
				$(".eltotal").text("$"+totalito.toFixed(2));
			}
		});

		//añadir
		$(document).on("click",".anadir",function(e){
			e.preventDefault();
			let ingre=$(".sel_ingre").val();
			if(ingre!=''){
				$(".sel_tamanio").prop("disabled",true);
				$(".sel_masa").prop("disabled",true);
				let texto=$(".sel_ingre option:selected").text();
				let id=$(".sel_ingre").val();
				let precio=parseFloat($(".sel_ingre option:selected").attr('data-precio'));
				$(".losingres").append("<li data-id="+id+">"+texto+"</li>");
				totalito=totalito+precio;
				$(".eltotal").text("$"+totalito.toFixed(2));
			}
		});

		//cancelar agregar orden
		$(document).on("click",".cancelar_orden",function(e){
			e.preventDefault();
			$(".agregar").hide();
			$(".armar").hide();
			$(".orden").show();

			$(".sel_tamanio").val("");
			$(".sel_masa").val("");
			$(".sel_ingre").val("");
			$(".sel_tamanio").prop("disabled",false);
			$(".sel_masa").prop("disabled",true);
			$(".sel_ingre").prop("disabled",true);
			$(".anadir").prop("disabled",true);
			totalito=0;
			$(".eltotal").text("$"+totalito.toFixed(2));
			$(".losingres").empty();
		});

		//cange de las especialidades
		$(document).on("change",".especialites",function(e){
			e.preventDefault();
			var id=$(this).val();
			if(id>0){
				$.ajax({
					url:'api/getSpeciality/'+id,
					type:'get',
					dataType:'json',
					success:function(json){
						if(json[0]==1){
							$(".detalle_especialidad").empty();
							$(".detalle_especialidad").html(json[2]);
						}
					}
				})
			}
		});

		//registrar pizza basica
		$(document).on("click",".basica",function(e){
			e.preventDefault();
			var id=$(this).attr("data-id");
			var precio=$(this).attr("data-precio");
			$.ajax({
				url:'/api/orders',
				type:'post',
				dataType:'json',
				data:{id_pizza:id,precio:precio,tipo:2,cantidad:1,token:localStorage.getItem('token')},
				success:function(json){
					if(json[0]==1){
						pendientes();
						$(".loscuantos").text(json[1]);
						$(".cancelar_orden").trigger("click");
						toastr.success("Agregado al carrito");	
					}else{

					}
				},error: function(error){

				}
			});
		});

		$(document).on("click",".addPersonalizada",function(e){
			e.preventDefault();
			var tamanio=$(".sel_tamanio").val();
			var masa=$(".sel_masa").val();
			let array_ingre=new Array();
			$(".losingres li").each(function(){
        	    console.log();
        	    array_ingre.push({
        	    	'ingredient_id':$(this).attr('data-id'),
        	    });
        	});
        	if(array_ingre.length>0){
			$.ajax({
				url:'/api/orders/personalizada',
				type:'post',
				dataType:'json',
				data:{masa_id:masa,tamanio_id:tamanio,array_ingre,total:totalito,tipo:4,cantidad:1,token:localStorage.getItem('token')},
				success:function(json){
					if(json[0]==1){
						pendientes();
						$(".loscuantos").text(json[1]);
						$(".cancelar_orden").trigger("click");
						toastr.success("Agregado al carrito");	
					}else{

					}
				},error: function(error){

				}
			});
			}else{
				toastr.info("Debe agregar un ingrediente");
			}
		});

		//agregar pizza de especialidad
		$(document).on("click",".addEspecialidad",function(e){
			e.preventDefault();
			var id=$(this).attr("data-id");
			var precio=$(this).attr("data-precio");
			$.ajax({
				url:'/api/orders',
				type:'post',
				dataType:'json',
				data:{id_pizza:id,precio:precio,tipo:1,cantidad:1,token:localStorage.getItem('token')},
				success:function(json){
					if(json[0]==1){
						pendientes();
						$(".loscuantos").text(json[1]);
						$(".cancelar_orden").trigger("click");
						toastr.success("Agregado al carrito");
					}else{

					}
				},error: function(error){

				}
			});

		});

		$(document).on("click",".addExtra",function(e){
			e.preventDefault();
			var id=$(".sel_extra").val();
			if(id!=''){
			var precio=$(".sel_extra option:selected").attr("data-precio");
			$.ajax({
				url:'/api/orders',
				type:'post',
				dataType:'json',
				data:{id_extra:id,precio:precio,tipo:3,token:localStorage.getItem('token')},
				success:function(json){
					if(json[0]==1){
						pendientes();
						$(".loscuantos").text(json[1]);
						$(".cancelar_orden").trigger("click");
						toastr.success("Agregado al carrito");
					}else{

					}
				},error: function(error){

				}
			});
			}else{
				toastr.info("Debe seleccionar un extra");
			}
		});



		//quitar especialidad
		$(document).on("click",".quitar_especialidad",function(e){
			e.preventDefault();
			var id=$(this).attr("data-id");
			var id_order=$(this).attr("data-order");
			var precio=$(this).attr("data-precio");
			$.ajax({
				url:'/api/orders/'+id,
				type:'delete',
				dataType:'json',
				data:{precio:precio,id_order,token:localStorage.getItem('token')},
				success:function(json){
					if(json[0]==1){
						pendientes();
						$(".loscuantos").text(json[1]);
						toastr.success("Eliminado con éxito del carrito");
					}else{

					}
				},error: function(error){

				}
			});
		});

		$(document).on("click",".quitar_personalizada",function(e){
			e.preventDefault();
			var id=$(this).attr("data-id");
			var id_perso=$(this).attr("data-order");
			var precio=$(this).attr("data-precio");
			$.ajax({
				url:'/api/orders/delete4/'+id,
				type:'delete',
				dataType:'json',
				data:{precio:precio,id_perso,token:localStorage.getItem('token')},
				success:function(json){
					if(json[0]==1){
						pendientes();
						$(".loscuantos").text(json[1]);
						toastr.success("Eliminado con éxito del carrito");
					}else{

					}
				},error: function(error){

				}
			});
		});

		//quitar bsica
		$(document).on("click",".quitar_basica",function(e){
			e.preventDefault();
			var id=$(this).attr("data-id");
			var id_order=$(this).attr("data-order");
			var precio=$(this).attr("data-precio");
			$.ajax({
				url:'/api/orders/delete2/'+id,
				type:'delete',
				dataType:'json',
				data:{precio:precio,id_order,token:localStorage.getItem('token')},
				success:function(json){
					if(json[0]==1){
						pendientes();
						$(".loscuantos").text(json[1]);
						toastr.success("Eliminado con éxito del carrito");
					}else{

					}
				},error: function(error){

				}
			});
		});

		//quitar bsica
		$(document).on("click",".quitar_extra",function(e){
			e.preventDefault();
			var id=$(this).attr("data-id");
			var id_extra=$(this).attr("data-extra");
			var precio=$(this).attr("data-precio");
			$.ajax({
				url:'/api/orders/delete3/'+id,
				type:'delete',
				dataType:'json',
				data:{precio:precio,id_extra,token:localStorage.getItem('token')},
				success:function(json){
					if(json[0]==1){
						pendientes();
						$(".loscuantos").text(json[1]);
						toastr.success("Eliminado con éxito del carrito");
					}else{

					}
				},error: function(error){

				}
			});
		});

		//ver el carrito
		$(document).on("click",".carrito",function(e){
			e.preventDefault();
			$(".agregar").show();
			$(".orden").hide();
		});

		//realizar el pedido
		$(document).on("click",".ordenar",function(e){
			e.preventDefault();
			var id=$(this).attr("data-id");
			$(".finalizar_pedido").attr("data-id",id);
			$("#modal_ordenar").modal("show");
		});

		//finalizar el pedido
		$(document).on("click",".finalizar_pedido",function(e){
			e.preventDefault();
			var id=$(this).attr("data-id");
			var datos=$("#form_confirmar").serialize();
			$.ajax({
				url:'api/orders/confirmar/'+id,
				type:'post',
				dataType:'json',
				data:datos,
				success:function(json){
					if(json[0]==1){
						pendientes();
						$(".loscuantos").text(json[2]);
						$("#modal_ordenar").modal("hide");
						window.open(
			                'pdf/'+json[1].id,
			                '_blank' // <- This is what makes it open in a new window.
			              );
					}
				}
			});
		});
	});

	function pendientes(){
		let token=localStorage.getItem('token');
		$.ajax({
			url:'/api/orders/getPending/'+token,
			type:'get',
			dataType:'json',
			success:function(json){
				if(json[0]==1){
					if(json[0]==1){
						$(".elcarrito").empty();
						$(".elcarrito").html(json[2]);
					}
				}
			}
		});
	}
</script>
@endsection