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

		//cancelar agregar orden
		$(document).on("click",".cancelar_orden",function(e){
			e.preventDefault();
			$(".agregar").hide();
			$(".orden").show();
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
						toastr.success("Agregado al carrito");	
					}else{

					}
				},error: function(error){

				}
			});
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