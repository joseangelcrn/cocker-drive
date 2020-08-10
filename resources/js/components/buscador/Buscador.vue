<template>
    <div>
        <div class="container" >
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="form-group" style="position:relative;">
                        <gif-loading style="position:absolute; right:0;bottom:3px;right:3px; " :show="labelButtonAdvancedSearching === 'Buscando ..' ? true : false"></gif-loading>
                        <input class="form-control" type="text" @keydown="buscar" placeholder="Nombre del archivo que deseas bucar.." v-model="fileNameToFind">
                    </div>
                    <div class="text-right my-2">
                        <!-- <button class="btn btn-primary">Hola</button> -->
                        <button class="btn" :class="[labelButtonAdvancedSearching === 'Buscando ..' ? 'btn-warning' : 'btn-secondary']" @click="busqAv = !busqAv">{{labelButtonAdvancedSearching}}</button>
                    </div>
                    <div class=" rounded bg-primary p-3" v-if="busqAv" id="cajon_busqueda_avanzada" style="position:absolute;z-index:3;width:100%;">
                        <div class="form-group border bg-secondary text-light p-3" id="orden">
                            <h5>Orden.</h5>
                            <hr>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="orden_created_at_desc" name="order_created_at" checked>
                                <label class="custom-control-label" for="orden_created_at_desc">Por creación (de mas nuevo a mas antiguo)</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="order_create_at_asc" name="order_created_at">
                                <label class="custom-control-label" for="order_create_at_asc">Por creacion (de mas antiguo a mas nuevo)</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="order_word_desc" name="order_word" checked>
                                <label class="custom-control-label" for="order_word_desc">Alfabeticamente (A-Z)</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="order_word_asc" name="order_word">
                                <label class="custom-control-label" for="order_word_asc">Alfabeticamente (Z-A)</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                <label class="custom-control-label" for="defaultUnchecked">Extension</label>
                            </div>
                        </div>
                        <div class="form-group border bg-secondary text-light p-3" id="tipo_archivo">
                            <h5>Tipo de archivo.</h5>
                            <hr>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="all_tipo" name="filtro_tipo" checked>
                                    <label class="custom-control-label" for="all_tipo">Todos.</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="documento" name="filtro_tipo">
                                    <label class="custom-control-label" for="documento">Documentos</label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="imagen" name="filtro_tipo">
                                        <label class="custom-control-label" for="imagen">Imagenes</label>
                                </div>

                        </div>
                        <div class="form-group border bg-secondary text-light p-3" id="tipo_extension">
                            <h5>Tipo de extensión.</h5>
                            <hr>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="all" name="filtro_extension">
                                    <label class="custom-control-label" for="all">Todas.</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="png" name="filtro_extension">
                                    <label class="custom-control-label" for="png">png</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="jpg" name="filtro_extension">
                                    <label class="custom-control-label" for="jpg">jpg</label>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" id="advanced_searching_result">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12  my-2" v-for="(file,index) in foundFiles" :key="file+index">
                    <fichero-miniatura  :fichero_param="file" :root_dir="root_dir"></fichero-miniatura>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['root_dir'],
        data(){
            return{
                fileNameToFind:'',
                busqAv:false,
                foundFiles:[],
                labelButtonAdvancedSearching:'Busqueda Avanzada',

            }
        },
        methods:{
            buscar(){
                this.labelButtonAdvancedSearching = 'Buscando ..';
                let that = this;
                let data = new FormData();
                data.append('file_name_to_find',this.fileNameToFind);

                 axios.post('/file/advanced_searching',data).then(
                    response => {
                        // console.log('response.data');
                        // console.log(response.data);
                        let data = response.data;
                        that.foundFiles = data.result;
                        this.labelButtonAdvancedSearching = 'Busqueda Avanzada';

                    },
                    error=>{
                        console.log('Error al actualizar el nombre de la imagen');
                        this.labelButtonAdvancedSearching = 'Busqueda Avanzada';

                    }
                )


            }
        },

    }
</script>


