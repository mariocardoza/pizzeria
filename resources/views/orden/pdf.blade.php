<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Pedido</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body>
	<div class="container">
		<div class="row">
		

    	<div class="col-sm-4"></div>
    	<div class="col-sm-8 ">
    		<div class="col-sm-12 text-center">
    			<h3>Pedido N° {{$orden->correlativo}}</h3>
    		</div>
    		<div class="col-sm-12 text-center">
    			<span>Fecha y hora: {{$orden->updated_at->format("d/m/Y H:i:s")}}</span>
    		</div>
    		<div class="col-sm-12 text-center">
    			<h4>Cliente: {{$orden->nombre}}</h4>
    		</div>
    		<div class="col-sm-12 text-center">
    			<h4>Correo electrónico: {{$orden->email}}</h4>
    		</div>
    		<div class="col-sm-12 text-center">
    			<h4>Teléfono: {{$orden->telefono}}</h4>
    		</div>
    		<div class="col-sm-12 text-center">
    			<h4>Dirección: {{$orden->direccion}}</h4>
    		</div>
    		<div class="col-sm-12 text-center">
    			<h4>Detalle del pedido</h4>
    		</div>
    	@foreach($orden->details as $d)
    		<div class="col-sm-12"><span class="float-left"><b>{{$d->pizzas->nombre}}</b></span><span class="float-right"><b>${{number_format($d->pizzas->precio,2)}}</b></span>&nbsp; </div>
    		<div class="col-sm-12"><ul>
    		@foreach($d->pizzas->ingredients as $i)
    			<li>{{$i->ingredient->nombre}}</li>
    		@endforeach
    		</ul></div>
    	@endforeach
    	
    	@foreach($orden->details2 as $d2)
    		<div class="col-sm-12"><span class="float-left"><b>{{$d2->pizzas->nombre}}</b></span><span class="float-right"><b>${{number_format($d2->pizzas->precio,2)}}</b></span> &nbsp;</div>
    		<div class="col-sm-12"><ul>
    			<li>{{$d2->pizzas->ingredient->nombre}}</li>
    		</ul></div>
    	@endforeach
    	@foreach($orden->extras as $e)
    		<div class="col-sm-12"><span class="float-left"><b>{{$e->extra->nombre}}</b></span><span class="float-right"><b>${{number_format($e->extra->precio,2)}}</b></span> &nbsp;<a class="quitar_extra" data-precio="'.$e->extra->precio.'" data-extra="'.$e->id.'" data-id="'.$orden->id.'" href="javascript:void(0)"><i style="color:red;" class="fas fa-trash"></i></a></div>
    	@endforeach
    	</div>
    	<div class="col-sm-12 text-center"><span class="float-right"><b style="font-size:20px;">Total: ${{number_format($orden->total,2)}}</b></span></div><br>
        
		</div>
	</div>
</body>
</html>