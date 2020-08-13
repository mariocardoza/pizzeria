@extends('layouts.master')

@section('content')
<div class="container-fluid">
	<h2>Dashboard</h2>
       <div class="row">

       	<div class="col-md-6">
       		<div class="card card-info">
       			<div class="card-header">
       				Pedidos
       			</div>
       			<div class="card-body">
       				<table class="table">
						<thead>
							<tr>
								<th>N°</th>
								<th>Fecha</th>
								<th>Hora</th>
								<th>N° pedido</th>
								<th>Total</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($pedidos as $index => $p)
							<tr>
								<td>{{$index+1}}</td>
								<td>{{$p->updated_at->format("d/m/Y")}}</td>
								<td>{{$p->updated_at->format("H:i:s")}}</td>
								<td>{{$p->correlativo}}</td>
								<td>${{number_format($p->total,2)}}</td>
								<td>
									<a href="{{url('pdf/'.$p->id)}}" target="_blank" class="btn btn-info"><i class="fas fa-print"></i></a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
       			</div>
       		</div>
       	</div>
       	<div class="col-md-6">
       		<div class="card card-info">
       			<div class="card-header">
       				Clientes frecuentes
       			</div>
       			<div class="card-body">
       				<table class="table">
						<thead>
							<tr>
								<th>N°</th>
								<th>Nombre</th>
								<th>Correo electrónico</th>
								<th>Cant. compras</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($frecuentes as $index => $f)
							<tr>
								<td>{{$index+1}}</td>
								<td>{{$f->nombre}}</td>
								<td>{{$f->email}}</td>
								<td>{{$f->veces}}</td>
								<td></td>
							</tr>
							@endforeach
						</tbody>
					</table>
       			</div>
       		</div>
       	</div>
       	<div class="col-md-6">
       		<div class="card card-info">
       			<div class="card-header">
       				Especialidades favoritas
       			</div>
       			<div class="card-body">
       				<table class="table">
						<thead>
							<tr>
								<th>N°</th>
								<th>Nombre</th>
								<th>Cant. compras</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($especialidades as $index => $f)
							<tr>
								<td>{{$index+1}}</td>
								<td>{{$f->nombre}}</td>
								<td>{{$f->veces}}</td>
								<td></td>
							</tr>
							@endforeach
						</tbody>
					</table>
       			</div>
       		</div>
       	</div>
       	<div class="col-md-6">
       		<div class="card card-info">
       			<div class="card-header">
       				Ingredientes favoritos
       			</div>
       			<div class="card-body">
       				<table class="table">
						<thead>
							<tr>
								<th>N°</th>
								<th>Nombre</th>
								<th>Cant. ordenes</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($ingredientes as $index => $f)
							<tr>
								<td>{{$index+1}}</td>
								<td>{{$f->nombre}}</td>
								<td>{{$f->veces}}</td>
								<td></td>
							</tr>
							@endforeach
						</tbody>
					</table>
       			</div>
       		</div>
       	</div>

       </div>
    </div>
@endsection
@section('scripts')
<script>
	$(".table").DataTable({
      "ordering": false,   
    });
</script>
@endsection