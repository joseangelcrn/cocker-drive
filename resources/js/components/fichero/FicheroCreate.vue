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

                    <div class="form-group row h-100">
                        <div class="col-lg-3 col-md-6   mt-2" :key="fichero+index" v-for="(fichero,index) in ficheros">
                            <!-- Si es Imagen pongo su imagen preview -->
                            <div v-if="extImagenesPermitidas.includes(fichero.extension)" class="text-center">
                                <img style="height:250px;" class="img-thumbnail" :src="fichero.url" alt="fichero">
                            </div>
                            <!-- Si es PDF: Icono PDF -->
                            <div v-else-if="fichero.extension == 'pdf'" class="text-center">
                                <img style="height:250px;" class="img-thumbnail" :src="'../storage/sistema/iconos/pdf.svg'" alt="Icono PDF">
                            </div>
                            <!-- Si es Doc/Docx: Icono Doc -->
                            <div v-else-if="extDocs.includes(fichero.extension)" class="text-center">
                                <img style="height:250px;" class="img-thumbnail" :src="'../storage/sistema/iconos/doc.jpg'" alt="Icono PDF">
                            </div>
                            <!-- Si es TXT:  Icono Txt -->
                            <div v-else-if="fichero.extension == 'txt'" class="text-center">
                                <img style="height:250px;" class="img-thumbnail" :src="'../storage/sistema/iconos/txt.png'" alt="Icono TXT">
                            </div>

                            <br>
                            <input class="form-control" type="text" title="Nombre con el que se guardara el fichero."   v-model="fichero.nombre_real">
                            <br>
                            <button type="button" class="btn btn-sm btn-danger w-100 align-bottom" @click="eliminarFichero(index)">Eliminar</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="resultado === false">
                            <strong>Oops..!</strong> Ha habido un problema al guardar tu(s) archivo(s).
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <button @click="guardar()" type="button" :disabled="disabledForm || resultado!= null" class="btn btn-primary">
                            Guardar Fichero
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data(){
            return{
                ficheros:[],
                //extensiones de imagenes permitidas
                extImagenesPermitidas:[
                    'png',
                    'jpg',
                    'jpeg',
                ],
                extDocs:[
                    'docs',
                    'doc',
                    'docx'
                ],
                resultado:null
            }
        },
        methods:{
            precargarFicheros(event){
                let ficheros = event.target.files;
                console.log('Ficheros precargados');
                console.log(ficheros);

                for (let i = 0; i < ficheros.length; i++) {
                    let fichero = ficheros[i];

                    /**
                     * Aqui me preparo un json personalizado parahacer mas comoda la legibilidad y
                     * su uso mas adelante en la vista.
                     */

                    let customJson = {};
                    customJson.bin = fichero;
                    customJson.url = URL.createObjectURL(fichero);
                    customJson.nombre_real = fichero.name.split('.')[0];
                    // customJson.nombre_real =
                    customJson.extension = fichero.name.split('.').pop();

                    this.ficheros.push(customJson);
                }
                // ficheros.forEach(fichero => {
                //     this.ficheros.push(fichero);
                // });

                console.log(this.ficheros);
            },
            eliminarFichero(index){
                let seguro = confirm('¿Estas seguro que deseas eliminar esta imagen?');
                if (seguro) {
                    // alert('Imagen borrada');
                    delete this.ficheros.splice(index, 1);
                }
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
            }
        }
    }
</script>
