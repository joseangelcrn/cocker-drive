<template>
  <div class="container">
        <div class="row bg-white rounded p-3">
            <div class="col-12 ">
                <form action="" method="post">
                    <div class="form-group">
                        <h3>Subida de fichero</h3>
                    </div>
                    <div class="form-group">
                        <label><b>Fichero:</b></label>
                       <input @change="precargarFicheros" class="form-control" type="file" name="ficheros" multiple>
                       <span class="ml-3">Extensiones permitidas: .jpg, .jpeg, .png, .txt, .pdf</span>
                    </div>
                        <transition-group  tag="div" name="list" class="form-group row h-100" >
                            <div class="col-lg-6" :key="fichero+index" v-for="(fichero,index) in ficheros">
                                <iconizador :fichero="fichero" :creating="true"></iconizador>
                                <br>
                                <input class="form-control sombra" type="text" title="Nombre con el que se guardara el fichero."   v-model="fichero.nombre_real">
                                <button type="button" class="btn btn-sm btn-danger w-100  mb-2" @click="eliminarFichero(index)"><i class="fa fa-trash" aria-hidden="true"></i></button>

                            </div>
                        </transition-group>
                    <div class="form-group">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="resultado === false">
                            <strong>Oops..!</strong> Ha habido un problema al guardar tu(s) archivo(s).
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <button @click="guardar()" type="button" :disabled="disabledForm || resultado!= null" class="btn btn-primary">
                            Guardar Fichero
                        </button>
                        <gif-loading class="ml-3"  :show="resultado != null"></gif-loading>
                    </div>
                    <div class="form-group border p-2" v-if="ficheros.length > 0">
                         <h4>Información de la subida</h4>
                         <p class="">Archivos seleccionados: <b>{{ficheros.length}}</b>.</p>
                         <p class="">Peso total de la subida:  <b>{{getTotalSizeOfFiles}}</b> KB. ( <b>{{Math.round((getTotalSizeOfFiles/1024 + Number.EPSILON) * 100) / 100}} MB</b> )</p>
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>
<style>
    .list-item {
    display: inline-block;
    margin-right: 10px;
    }
    .list-enter-active, .list-leave-active {
    transition: all 1s;
    }
    .list-enter, .list-leave-to /* .list-leave-active below version 2.1.8 */ {
    opacity: 0;
    transform: translateY(30px);
    }
</style>
<script>
    export default {
        data(){
            return{
                ficheros:[],
                resultado:null,
                csrf:null
            }
        },
        methods:{
            precargarFicheros(event){
                let ficheros = event.target.files;
                for (let i = 0; i < ficheros.length; i++) {
                    let fichero = ficheros[i];

                    let customJson = {};
                    customJson.bin = fichero;
                    customJson.url = URL.createObjectURL(fichero);
                    customJson.nombre_real = fichero.name.split('.')[0];
                    // customJson.nombre_real =
                    customJson.extension = fichero.name.split('.').pop();

                    this.ficheros.push(customJson);
                }

            },
            eliminarFichero(index){
                this.$confirm(
                                {
                                message: `¿Estas seguro que deseas eliminar este archivo?`,
                                button: {
                                    no: 'No',
                                    yes: 'Si'
                                },
                                /**
                                 * Callback Function
                                 * @param {Boolean} confirm
                                 */
                                callback: confirm => {
                                    console.log('call back');
                                    if (confirm) {
                                        delete this.ficheros.splice(index, 1);
                                    }
                                }
                            }
                        );
                },
            guardar(){
                console.log('Guardar Ficheros !');
                console.log(this.ficheros);

                let config = {
                    header : {
                        'Content-Type' : 'multipart/form-data',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                }

                var data = new FormData();

                this.ficheros.forEach(fichero => {
                    data.append('ficheros[]',fichero.bin,fichero.nombre_real);
                });

                this.resultado = -1;

                axios.post('/fichero', data, config).then(
                    response => {
                        console.log('response data');
                        let resultado = response.data['resultado'];
                        console.log(response.data);
                        if (resultado) {
                            window.location.href = "/home";
                        }
                        else{
                            this.resultado = false;
                        }
                    },
                    error=>{
                        this.resultado = false;
                    }
                )
            }
        },
        beforeMount(){
            setCsrf: {
                console.log('hola');
               this.csrf = document.querySelector('meta[name="csrf-token"]').content;
            }
        },
        mounted() {
        },
        computed: {
            //sera true siempre que este vacio el array de ficheros
            // create-stage
            disabledForm(){
                let resultado = true;
                if (this.ficheros.length > 0) {
                    resultado =  false;
                }
                return resultado;
            },

            getTotalSizeOfFiles(){
                let sumSize = 0;

                this.ficheros.forEach(file => {
                    // console.log(file);
                    let sizeKB = file.bin.size / 1024;

                    sumSize += Math.round((sizeKB + Number.EPSILON) * 100) / 100;
                });

                return sumSize;
            }
        }
    }
</script>
