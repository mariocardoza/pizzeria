<template>
	<div class="row">
		<div class="col-md-12">
			<div class="card card-info">
				<div class="card-header">
					Orden de pizza
				</div>
					Seleccione
					<div class="row" v-if="orden">
						<div class="col-md-3">
							<div class="card" >
					  
							  <div class="card-body">
							    <h5 class="card-title">Pizza de Especialidad</h5>
							    <img class="card-img-top" :src="'images/suprema.jpg'" width="40" height="130" alt="Card image cap">
							    <button @click="orderSpeciality()" class="btn btn-info">Ordenar</button>
							    <span class="float-right">$16.99</span>
							  </div>
							</div>
						</div>
						<div class="col-md-3" v-for="pizza in pizzas.data">
							<div class="card" >
					  
							  <div class="card-body">
							    <h5 class="card-title">{{pizza.nombre}}</h5>
							    <img class="card-img-top" :src="'images/pizza.jpg'" width="40" height="130" alt="Card image cap">
							    <a href="#" class="btn btn-info">Ordenar</a>
							    <span class="float-right">${{pizza.precio}}</span>
							  </div>
							</div>
						</div>
					</div>
					<div class="row" v-else>
						<div class="card card-info col-md-6">
							<div class="card-header">
								Seleccione la especialidad
							</div>
							<div class="card-body">
								<div class="row">
									<select @change="loadPizzita()" v-model="laespecialidad" class="form-control">
										<option v-bind:value="0">Seleccionar una especialidad</option>
										<option v-for="especialidad in especialidades.data" v-bind:value="especialidad.id">{{especialidad.nombre}} {{especialidad.tamanio.nombre}}</option>
									</select>
								</div>
								<div v-if="mostrarorden">
									
								
									<div class="row" >
										<div class="col-sm-12">
											<span class="float-left">{{laorden.nombre}} {{laorden.tamanio.nombre}}</span>
										<span class="float-right">${{totalp}}</span>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<ul >
											<li  v-for="ingre in laorden.ingredients">
												{{losIngredientes(ingre.ingredient_id)}}
											</li>	
										</ul>
										</div>
										<hr>
									</div>
									<!--div class="row">
										<div class="col-sm-12">
											<button class="btn btn-link" @click="otrosIngredientes()"><i class="fas fa-plus"></i> Extras</button>
											
										</div>
									</div>
									<div class="row" v-if="otrosingre">
										<ul >
											<li @click="addIngre(ingre.id)" v-for="ingre in ingredients.data">{{ingre.nombre}} ${{ingre.precio}} <button class="btn btn-link"><i class="fas fa-plus"></i></button></li>
										</ul>
									</div-->
									<div class="row">
										<button class="btn btn-info" @click="addCarrito(laorden.id)">Agregar</button>
										<button class="btn btn-danger" @click="cancelar()">Cancelar</button>
									</div>
								</div >
							</div>
						</div>
						<div class="card card-info col-md-6">
							<div class="card-header">
								Carrito
							</div>
							<div class="card-body">
								<ul>
									<li v-for="o in pizzasOrder"><span class="float-left">{{o.pizzas.nombre}} </span><span class="float-right">${{o.pizzas.precio}}</span></li>
								</ul>
								<h3>Total ${{pending.total}}</h3><br>
								<button class="btn btn-info">Confirmar</button>
							</div>
						</div>
						
					</div>
			</div>
		</div>
	</div>
</template>
<script>
    export default {
        data(){
            return {
              	pizzas:[],
              	pizzasOrder:[],
              	pending:[],
              	especialidades:[],
             	orden:true,
             	laespecialidad:'',
             	laorden:[],
             	mostrarorden:false,
             	ingredients:[],
             	totalp:0.00,
             	otrosingre:false,
             	adicionales:0,
            }
        },
        mounted() {
            console.log('Component orden.')
            this.loadPizzas();
            this.loadIngredients();
            this.getPending();
        },
        methods:{

        	loadPizzas(){
               axios.get('/api/basics')
                .then((response)=>{
                    this.pizzas=response.data
                }).catch(e => {
                    console.log("Error:"+e);
                }); 
            },
            loadIngredients(){
                axios.get('/api/allIngredients')
                .then((response)=>{

                    this.ingredients=response
                }).catch(e => {
                    console.log("Error:"+e);
                });
            },
            losIngredientes(id){
                let ingredients=this.ingredients.data;
                let i;
                for (i = 0; i < ingredients.length; i++) {
                if(ingredients[i].id===id){
                    return ingredients[i].nombre;
                }
                }
            },
            loadPizzita(){
            	axios.get('/api/getSpeciality/'+this.laespecialidad)
                .then((response)=>{
                    this.laorden=response.data
                    this.mostrarorden=true;
                    this.totalp=this.laorden.precio;
                }).catch(e => {
                    console.log("Error:"+e);
                }); 
            },
            addCarrito(id)
            {
            	axios.post('/api/orders',{id_pizza:id,cantidad:1,tipo:1,total:this.totalp})
                .then((response)=>{
                    toastr.success("Guardado");
                   	this.getPending();
                }).catch(e => {
                    let esto=this;
                    $.each(e.response.data.errors, function(key, value) {
                        toastr.error(value);
                        });
                    
                    setTimeout(function () {
                        esto.errores = [];
                    }, 5000);
                });
            },
            getPending(){
            	axios.get('/api/orders/getPending')
                .then((response)=>{
                    this.pending=response.data[0];
                    this.pizzasOrder=response.data[1];
                }).catch(e => {
                    console.log("Error:"+e);
                }); 
            },
            orderSpeciality(){
            	this.orden=false;
            	this.loadSpecialities();
            },
            loadSpecialities(){
            	axios.get('/api/allSpecialities')
                .then((response)=>{
                    this.especialidades=response
                }).catch(e => {
                    console.log("Error:"+e);
                }); 
            },
            cancelar(){
            	this.orden=true;
            },
            otrosIngredientes(){
            	this.otrosingre=true;
            },
            addIngre(id){
            	let precio=0;
            	this.otrosingre=false;
            	//this.adicionales=this.adicionales+1;
            	 let ingredients=this.ingredients.data;
                let i;
                for (i = 0; i < ingredients.length; i++) {
                if(ingredients[i].id===id){
                	this.precio=ingredients[i].precio;
                    return ingredients[i].nombre;
                }
                }
                //this.totalp=this.totalp+precio;
                alert(precio);
            },
        }
        
    }
</script>