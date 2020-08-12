<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">Tipo masa</div>

                    <div class="card-body">
                    <form method="POST" v-on:submit.prevent="guardarMasa()">
                        <div class="form-row">
                        <div class="col">
                        <div v-if="nuevoM">
                            Nombre: <input type="text" placeholder="Ingrese el tipo de masa" class="form-control" v-model="nombre" autofocus>
                        </div>
                        <div v-if="nuevoM">
                            <ul v-if="errores.length" class="list-group">
                                <li class="list-group-item list-group-item-danger">Por favor, corrija los siguientes errores:</li>
                                <li class="list-group-item" v-for="error in errores">{{ error }}</li>
                            </ul>
                        </div>
                        </div>
                        <div class="col">
                        <div v-if="nuevoM">
                            Precio (opcional):
                            <input class="form-control" v-model="precio" placeholder="Digite el precio (si aplica)" type="text">
                            
                        </div>
                        </div>
                        <div class="col-md-auto my-auto" v-if="nuevoM">
                            <div v-if="nuevoM">
                                <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Guardar"><i class="fas fa-check-circle"></i></button>
                                <button class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Cancelar" @click="nuevoM=!nuevoM,nombre='',precio='',errores=[]"><i class="fas fa-times-circle"></i></button>
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <div v-if="!nuevoM">
                                <button class="btn btn-info float-right" @click="nuevoM=!nuevoM">Nuevo tipo de masa</button>
                            </div>
                        </div>
                        </div>
                    </form>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Masa</th>
                                    <th>Precio</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(masa,index) in masas">
                                    <td>{{index+1}}</td>
                                    <td>{{masa.nombre}}</td>
                                    <td>{{masa.precio}}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">Tamaño (porciones)</div>

                    <div class="card-body">
                        <form method="POST" v-on:submit.prevent="guardarTamanio()">
                        <div class="form-row">
                        <div class="col">
                        <div v-if="nuevoT">
                            Nombre: <input type="text" placeholder="Ingrese el tipo de masa" class="form-control" v-model="nombret" autofocus>
                        </div>
                        <div v-if="nuevoT">
                            <ul v-if="errorest.length" class="list-group">
                                <li class="list-group-item list-group-item-danger">Por favor, corrija los siguientes errores:</li>
                                <li class="list-group-item" v-for="error in errorest">{{ error }}</li>
                            </ul>
                        </div>
                        </div>
                        <div class="col">
                        <div v-if="nuevoT">
                            Precio (opcional):
                            <input class="form-control" v-model="preciot" placeholder="Digite el precio" type="text">
                            
                        </div>
                        </div>
                        <div class="col-md-auto my-auto" v-if="nuevoT">
                            <div v-if="nuevoT">
                                <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Guardar"><i class="fas fa-check-circle"></i></button>
                                <button class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Cancelar" @click="nuevoT=!nuevoT,nombret='',preciot='',errorest=[]"><i class="fas fa-times-circle"></i></button>
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <div v-if="!nuevoT">
                                <button class="btn btn-info float-right" @click="nuevoT=!nuevoT">Nuevo tamaño</button>
                            </div>
                        </div>
                        </div>
                    </form>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Tamaño</th>
                                    <th>Precio</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(tamanio,index) in tamanios">
                                    <td>{{index+1}}</td>
                                    <td>{{tamanio.nombre}}</td>
                                    <td>${{tamanio.precio}}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
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
              masas:[],
              tamanios:[],
              nombre:'',
              precio:'',
              nombret:'',
              preciot:'',
              errores:[],
              errorest:[],
              nuevoM:false,
              nuevoT:false,
              actualizarM:false,
              actualizarT:false,
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.verMasas();
            this.verTamanios();
        },
        methods: {
            guardarMasa: function () {
                this.errores = [];
                if(!this.nombre){
                    this.errores.push('El nombre es obligatorio.');
                    let esto=this;
                    setTimeout(function () {
                            esto.errores = [];
                        }, 5000);
                }else{
                    axios.post('api/masas',{ nombre:this.nombre,precio:this.precio})
                    .then((response)=>{
                        toastr.success("Guardado");
                        this.verMasas();
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
            verMasas(){
                axios.get('api/masas')
                .then((response)=>{
                    this.masas=response.data
                }).catch(e => {
                    console.log("Error:"+e);
                });
            },
            borrar: function(id){
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
                       axios.delete('api/parametros/'+id)
                        .then(response => {
                            this.$swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Eliminado',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            this.ver();
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
            verTamanios(){
                axios.get('api/tamanios')
                .then((response)=>{
                    this.tamanios=response.data
                }).catch(e => {
                    console.log("Error:"+e);
                });
            },
            guardarTamanio: function () {
                this.errores = [];
                if(!this.nombret && !this.preciot){
                    this.errorest.push('El nombre y el precio son obligatorios.');
                    let esto=this;
                    setTimeout(function () {
                            esto.errorest = [];
                        }, 5000);
                }else{
                    axios.post('api/tamanios',{ nombre:this.nombret,precio:this.preciot})
                    .then((response)=>{
                        toastr.success("Guardado");
                        this.verTamanios();
                        this.nombret='';
                        this.preciot='';
                        this.errorest = [];
                        this.nuevoT=false;
                    }).catch(e => {
                        let esto=this;
                        $.each(e.response.data.errors, function(key, value) {
                            esto.errores.push(value);
                            });
                        this.nombret='';
                        this.preciot='';
                        setTimeout(function () {
                            esto.errorest = [];
                        }, 5000);
                    });
                }
            },
            
        }//Fin metodos
    }
</script>