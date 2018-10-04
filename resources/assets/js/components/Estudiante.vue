<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Categorías
                        <button type="button" @click="abrirModal('estudiante','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="codigoEstudiante">Codigo</option>
                                      <option value="nombres">Nombres</option>
                                      <option value="apellidos">Apellidos</option>
                                      <option value="email">Email</option>
                                      <option value="condicion">Condicion</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarEstudiante(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarEstudiante(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Codigo de Estudiante</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Email</th>
                                    <th>Condicion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="estudiante in arrayEstudiante" :key="estudiante.id">
                                    <td>
                                        <button type="button" @click="abrirModal('estudiante','actualizar',estudiante)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="estudiante.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarEstudiante(estudiante.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarEstudiante(estudiante.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="estudiante.codigoEstudiante"></td>
                                    <td v-text="estudiante.nombres"></td>
                                    <td v-text="estudiante.apellidos"></td>
                                    <td v-text="estudiante.email"></td>
                                    <td>
                                        <div v-if="estudiante.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Codigo de Estudiante</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="codigoEstudiante" class="form-control" placeholder="Ingrese el codigo de estudiante">    
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombres</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombres" class="form-control" placeholder="Ingrese los nombres del estudiante">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Apellidos</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="apellidos" class="form-control" placeholder="Ingrese los apellidos del estudiante">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="email" class="form-control" placeholder="Ingrese el email del estudiante">
                                    </div>
                                </div>
                                <div v-show="errorEstudiante" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjEstudiante" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarEstudiante()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarEstudiante()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    export default {
        data (){
            return {
                estudiante_id: 0,
                codigoEstudiante:'',
                nombres : '',
                apellidos : '',
                email:'',
                arrayEstudiante : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorEstudiante : 0,
                errorMostrarMsjEstudiante : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'codigoEstudiante',
                buscar : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {
            listarEstudiante (page,buscar,criterio){
                let me=this;
                var url= '/estudiante?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayEstudiante = respuesta.estudiantes.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarEstudiante(page,buscar,criterio);
            },
            registrarEstudiante(){
                if (this.validarEstudiante()){
                    return;
                }
                
                let me = this;

                axios.post('/estudiante/registrar',{
                    'codigoEstudiante': this.codigoEstudiante,
                    'nombres': this.nombres,
                    'apellidos': this.apellidos,
                    'email':this.email
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarEstudiante(1,'','codigoEstudiante');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarEstudiante(){
               if (this.validarEstudiante()){
                    return;
                }
                
                let me = this;

                axios.put('/estudiante/actualizar',{
                    'codigoEstudiante': this.codigoEstudiante,
                    'nombres': this.nombres,
                    'apellidos': this.apellidos,
                    'email':this.email,
                    'id': this.estudiante_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarEstudiante(1,'','codigoEstudiante');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarEstudiante(id){
               swal({
                title: 'Esta seguro de desactivar este estudiante?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/estudiante/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarEstudiante(1,'','codigoEstudiante');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            activarEstudiante(id){
               swal({
                title: 'Esta seguro de activar esta categoría?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/estudiante/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarEstudiante(1,'','codigoEstudiante');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            validarEstudiante(){
                this.errorEstudiante=0;
                this.errorMostrarMsjEstudiante =[];
                if (!this.codigoEstudiante) this.errorMostrarMsjEstudiante.push("El campo codigo del estudiante no puede estar vacío.");
                if (!this.nombres) this.errorMostrarMsjEstudiante.push("El campo nombres del estudiante no puede estar vacío.");
                if (!this.apellidos) this.errorMostrarMsjEstudiante.push("El campo apellidos del estudiante no puede estar vacío.");
                if (this.errorMostrarMsjEstudiante.length) this.errorEstudiante = 1;

                return this.errorEstudiante;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.codigoEstudiante='';
                this.nombres='';
                this.apellidos='';
                this.email='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "estudiante":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar estudiante';
                                this.codigoEstudiante= '';
                                this.nombres= '';
                                this.apellidos= '';
                                this.email = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar estudiante';
                                this.tipoAccion=2;
                                this.estudiante_id=data['id'];
                                this.codigoEstudiante = data['codigoEstudiante'];
                                this.nombres = data['nombres'];
                                this.apellidos= data['apellidos'];
                                this.email = data['email'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarEstudiante(1,this.buscar,this.criterio);
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
