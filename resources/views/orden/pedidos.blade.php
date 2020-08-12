@extends('layouts.orden')
@section('content')
<div class="container-fluid">
    <div class="row">
		<div class="col-md-12">
			<div class="card card-info">
				<div class="card-header">
					Pedidos realizados
				</div>
				<div class="card-body">
					<table class="table">
						<thead>
							<tr>
								<th>N°</th>
								<th>Fecha</th>
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
	</div>
</div>
@endsection
