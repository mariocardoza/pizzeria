<template>
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-10">
                <div class="card card-info">
                    <div class="card-header">Ingredientes</div>

                    <div class="card-body">
                        <form method="POST" v-on:submit.prevent="saveIngredient()">
                        <div class="form-row">
                        <div class="col">
                        <div v-if="nuevo">
                            Nombre: <input type="text" placeholder="Ingrese el nombre del ingrediente" class="form-control" v-model="nombre" autofocus>
                        </div>
                        <div v-if="nuevo">
                            <ul v-if="errores.length" class="list-group">
                                <li class="list-group-item list-group-item-danger">Por favor, corrija los siguientes errores:</li>
                                <li class="list-group-item" v-for="error in errores">{{ error }}</li>
                            </ul>
                        </div>
                        </div>
                        <div class="col">
                        <div v-if="nuevo">
                            Precio:
                            <input class="form-control" v-model="precio" placeholder="Digite el precio" type="text">
                            
                        </div>
                        </div>
                        <div class="col-md-auto my-auto" v-if="nuevo">
                            <div v-if="nuevo">
                                <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Guardar"><i class="fas fa-check-circle"></i></button>
                                <button class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Cancelar" @click="nuevo=!nuevo,nombre='',precio='',errores=[]"><i class="fas fa-times-circle"></i></button>
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <div v-if="!nuevo">
                                <button class="btn btn-info float-right" @click="nuevo=!nuevo">Nuevo ingrediente</button>
                            </div>
                        </div>
                        </div>
                    </form>
                    <hr v-if="nuevo">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Imagen</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(ingredient,index) in ingredients.data" :key="ingredient.id">
                                    <td>{{index+1}}</td>
                                    <td>
                                        <input v-if="actualizar  && idUpdate == index" class="form-control" type="text" v-model="ingredient.nombre" name="nombre">
                                        <span v-else>{{ingredient.nombre}}</span></td>
                                    <td>
                                        <input v-if="actualizar  && idUpdate == index" type="text" class="form-control" name="precio" v-model="ingredient.precio">
                                        <span v-else>${{ingredient.precio}}</span>
                                    </td>
                                    <td>
                                        <img :src="'images/ingredientenodisponible.jpg'" width="40" height="40" alt="">
                                    </td>
                                    <td>
                                        <button v-if="actualizar  && idUpdate == index" class="btn btn-success" v-on:click="updateIngredient(index,ingredient.id)"><i class="fas fa-check-circle"></i></button>
                                        <button v-if="actualizar  && idUpdate == index" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Cancelar" @click="actualizar=!actualizar"><i class="fas fa-times-circle"></i></button>
                                        <button v-else class="btn btn-warning" v-on:click.prevent="onEdit(index)"><i class="fas fa-edit"></i></button>
                                        <button v-if="!actualizar" class="btn btn-danger" v-on:click.prevent="deleteIngredient(ingredient.id)"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav>
                    <ul class="pagination float-right">
                        <li class="page-item" v-show="ingredients['prev_page_url']">
                            <a href="#" class="page-link" @click.prevent="getPreviousPage">
                                <span>
                                  <span aria-hidden="true">«</span>
                                </span>
                            </a>
                        </li>
                        <li class="page-item" :class="{ 'active': (ingredients['current_page']=== n) }" v-for="n in ingredients['last_page']">
                            <a href="#" class="page-link" @click.prevent="getPage(n)">
                                <span >
                                    {{ n }}
                                </span>
                            </a>
                        </li>
                        <li class="page-item" v-show="ingredients['next_page_url']">
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
</template>

<script>
    export default {
        data(){
            return {
                ingredients:[],
                nombre:'',
                precio:'',
                errores:[],
                idUpdate:-1,
                nuevo:false,
                actualizar:false,
            }
        },
        mounted() {
            console.log('Component ingredients.')
            this.loadIngredients();
        },
        methods: {
            
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
            loadIngredients(){
                axios.get('/api/ingredients')
                .then((response)=>{
                    this.ingredients=response.data
                }).catch(e => {
                    console.log("Error:"+e);
                });
            },
            saveIngredient: function () {
                this.errores = [];
                if(!this.nombre && !this.precio){
                    this.errores.push('El nombre y el precio son obligatorios.');
                    let esto=this;
                    setTimeout(function () {
                            esto.errores = [];
                        }, 5000);
                }else{
                    axios.post('/api/ingredients',{ nombre:this.nombre,precio:this.precio})
                    .then((response)=>{
                        toastr.success("Guardado");
                        this.loadIngredients();
                        this.nombre='';
                        this.precio='';
                        this.errores = [];
                        this.nuevo=false;
                    }).catch(e => {
                        let esto=this;
                        $.each(e.response.data.errors, function(key, value) {
                            esto.errores.push(value);
                            });
                        this.nombre='';
                        this.precio='';
                        setTimeout(function () {
                            esto.errores = [];
                        }, 5000);
                    });
                }
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
                axios.get('/api/ingredients?page='+page).then((response)=>{
                    this.$set(this.$data, 'ingredients', response.data);
                },(response)=>{
                });
            },
            getPreviousPage(){
                axios.get(this.ingredients['prev_page_url']).then((response)=>{
                    this.$set(this.$data, 'ingredients', response.data);
                },(response)=>{
                });
            },
            getNextPage(){
                axios.get(this.ingredients['next_page_url']).then((response)=>{
                    this.$set(this.$data, 'ingredients', response.data);
                },(response)=>{
                });
            },
            
        }//Fin metodos
    }
</script>