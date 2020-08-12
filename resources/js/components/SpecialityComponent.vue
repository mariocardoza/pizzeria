<template>
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">Pizza de especialidad</div>

                    <div class="card-body">
                        <div class="col-md-auto">
                            <div v-if="!nuevo">
                                <button class="btn btn-info float-right" @click="newPizza()">Nueva pizza</button>
                            </div>
                        </div>
                        <form method="POST" v-if="nuevo" v-on:submit.prevent="savePizza()">
                        <div class="form-row">
                        <div class="col">
                        <div v-if="nuevo">
                            Nombre: <input type="text" placeholder="Ingrese el nombre de la pizza" class="form-control" v-model="nombre" autofocus>
                        </div>
                        
                        </div>
                        <div class="col">
                            <div v-if="nuevo">
                                Precio:
                                <input class="form-control" v-model="precio" placeholder="Digite el precio" type="text">
                                
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <div v-if="nuevo">
                                Tamaño (porciones)
                                <select v-model="size" class="form-control">
                                    <option value="">Seleccione</option>
                                    <option v-for="size in sizes.data" v-bind:value="size.id">{{size.nombre}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div v-if="nuevo">
                                Tipo de masa
                                <select v-model="masa" class="form-control">
                                    <option value="">Seleccione</option>
                                    <option v-for="masa in masas.data" v-bind:value="masa.id">{{masa.nombre}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div v-if="nuevo">
                                Ingredientes
                                <select v-model="ingredient" multiple="multiple" class="form-control">
                                    <option v-for="ingredient in ingredients.data" v-bind:value="ingredient.id">{{ingredient.nombre}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-auto my-auto" v-if="nuevo">
                            <div v-if="nuevo">
                                <br>
                                <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Guardar"><i class="fas fa-check-circle"></i> Guardar</button>
                                <button class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Cancelar" @click="nuevo=!nuevo,nombre='',precio='',errores=[]"><i class="fas fa-times-circle"></i> Cancelar</button>
                            </div>
                        </div>
                        
                        </div>
                    </form>
                    <div v-else>
                        <table  class="table">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Tamaño</th>
                                    <th>Tipo masa</th>
                                    <th>Ingredientes</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(pizza,index) in pizzas.data">
                                    <td>{{index+1}}</td>
                                    <td>{{pizza.nombre}}</td>
                                    <td>${{pizza.precio}}</td>
                                    <td>{{pizza.tamanio.nombre}}</td>
                                    <td>{{pizza.masa.nombre}}</td>
                                    <td width="20%">
                                       <li v-for="ingredient in pizza.ingredients">{{losIngredientes(ingredient.ingredient_id)}}</li>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" v-on:click.prevent="deletePizza(pizza.id)"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination float-right">
                                <li class="page-item" v-show="pizzas['prev_page_url']">
                                    <a href="#" class="page-link" @click.prevent="getPreviousPage">
                                        <span>
                                          <span aria-hidden="true">«</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="page-item" :class="{ 'active': (pizzas['current_page']=== n) }" v-for="n in pizzas['last_page']">
                                    <a href="#" class="page-link" @click.prevent="getPage(n)">
                                        <span >
                                            {{ n }}
                                        </span>
                                    </a>
                                </li>
                                <li class="page-item" v-show="pizzas['next_page_url']">
                                    <a href="#" class="page-link" @click.prevent="getNextPage">
                                        <span>
                                          <span aria-hidden="true">»</span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
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
                ingredients:[],
                specialities:[],
                masas:[],
                sizes:[],
                nombre:'',
                precio:'',
                size:'',
                masa:'',
                ingredient:[],
                errores:[],
                idUpdate:-1,
                nuevo:false,
                actualizar:false,
            }
        },
        mounted() {
            console.log('Component ingredients.')
            this.loadPizzas();
            this.loadIngredients();
        },
        methods: {
            newPizza(){
                this.nuevo=true;
                
                this.loadMasas();
                this.loadSizes();
            },
            deletePizza(id){
                this.$swal.fire({
                    title: '¿Está seguro de borrar?',
                    text: "¡Ya no estará disponible!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borrar',
                    cancelButtonText: 'Cancelar'
                    }).then((result) => {
                    if (result.value) {
                       axios.delete('/api/specialities/'+id)
                        .then(response => {
                            this.$swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Eliminado',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            this.loadPizzas();
                        }).catch(error => {
                            console.log(error);
                        });

                    }else{
                        this.$swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Cancelado',
                                showConfirmButton: false,
                                timer: 1500
                            });
                    }
                    });
            },
            
            deleteIngredient(id){
                this.$swal.fire({
                    title: '¿Está seguro de borrar?',
                    text: "¡Ya no estará disponible!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borrar',
                    cancelButtonText: 'Cancelar'
                    }).then((result) => {
                    if (result.value) {
                       axios.delete('/api/ingredients/'+id)
                        .then(response => {
                            this.$swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Eliminado',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            this.loadIngredients();
                        }).catch(error => {
                            console.log(error);
                        });

                    }else{
                        this.$swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Cancelado',
                                showConfirmButton: false,
                                timer: 1500
                            });
                    }
                    });
            },


            //tamaños de pizzas
            losIngredientes(id){
                let ingredients=this.ingredients.data;
                let i;
                for (i = 0; i < ingredients.length; i++) {
                if(ingredients[i].id===id){
                    return ingredients[i].nombre;
                }
                }
            },
            loadIngredients(){
                axios.get('/api/allIngredients')
                .then((response)=>{

                    this.ingredients=response
                }).catch(e => {
                    console.log("Error:"+e);
                });
            },
            loadMasas(){
                axios.get('/api/masas')
                .then((response)=>{
                    this.masas=response;
                }).catch(e => {
                    console.log("Error:"+e);
                });
            },
            loadSizes(){
                axios.get('/api/tamanios')
                .then((response)=>{
                    this.sizes=response
                }).catch(e => {
                    console.log("Error:"+e);
                });
            },
            loadPizzas(){
               axios.get('/api/specialities')
                .then((response)=>{
                    this.pizzas=response.data
                }).catch(e => {
                    console.log("Error:"+e);
                }); 
            },
            savePizza: function () {
                axios.post('/api/specialities',{nombre:this.nombre,precio:this.precio,masa:this.masa,size:this.size,ingredient:this.ingredient})
                .then((response)=>{
                    toastr.success("Guardado");
                    this.loadPizzas();
                    this.nombre='';
                    this.precio='';
                    this.masa='';
                    this.size='';
                    this.ingredient=[];
                    this.nuevo=false;
                }).catch(e => {
                    let esto=this;
                    $.each(e.response.data.errors, function(key, value) {
                        toastr.error(value);
                        });
                    this.nombre='';
                    this.precio='';
                    this.masa='';
                    this.size='';
                    this.ingredient=[];
                    setTimeout(function () {
                        esto.errores = [];
                    }, 5000);
                });
                
            },
            onEdit: function (index) {
                // Antes de mostrar el formulario de actualizar, rellenamos sus campos
                this.idUpdate = index;
                
                // Mostramos el formulario
                this.actualizar = true;
            },

            updateIngredient(index,id){
                let datos={
                    nombre:this.ingredients.data[index].nombre,
                    precio:this.ingredients.data[index].precio
                };
                axios.put('/api/ingredients/'+id,datos)
                .then((response)=>{
                    toastr.success("Editado");
                    this.loadIngredients();
                    this.actualizar=false;
                });
            },

            //mettodos para la paginacion
            getPage(page){
                axios.get('/api/specialities?page='+page).then((response)=>{
                    this.$set(this.$data, 'specialities', response.data);
                },(response)=>{
                });
            },
            getPreviousPage(){
                axios.get(this.pizzas['prev_page_url']).then((response)=>{
                    this.$set(this.$data, 'specialities', response.data);
                },(response)=>{
                });
            },
            getNextPage(){
                axios.get(this.pizzas['next_page_url']).then((response)=>{
                    this.$set(this.$data, 'specialities', response.data);
                },(response)=>{
                });
            },
            
        }//Fin metodos
    }
</script>