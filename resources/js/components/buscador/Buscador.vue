<template>
    <div>
        <div class="container" >
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="form-group" style="position:relative;">
                        <gif-loading style="position:absolute; right:0;bottom:3px;right:3px; " :show="labelButtonAdvancedSearching === 'Buscando ..' ? true : false"></gif-loading>
                        <input class="form-control" type="text" @keyup="buscar" placeholder="Buscar archivo..." v-model="fileNameToFind">
                    </div>
                    <div class="row my-2 ">
                      <div class="col-12 fixed-right">
                        <button id="toggle_button_filters"  class="btn text-white "  @click="show.tog_but_adv_sear = !show.tog_but_adv_sear"><i class="fas fa-cog"></i></button>
                        <transition name="slide-fade">
                            <!-- Filters Box  (start)-->
                            <div id="filters_box" class="bg-white mt-5  p-2 rounded border border-primary"  v-if="show.tog_but_adv_sear">

                                <div class="form-group">
                                    <!-- <h5>Extensiones</h5>
                                    <hr> -->
                                    <ul>
                                        <li v-for="(extension,index) in filters.extensions" :key="index">
                                            <input type="checkbox" :id="extension" :value="extension" v-model="filters.selectedExtensions">
                                            <label class="mr-2" :for="extension">{{extension}}</label>
                                        </li>
                                    </ul>
                                </div>

                                <div class="form-group row">
                                    <div class="col-12">
                                        <h5>Ordenar por</h5>
                                        <hr>
                                    </div>
                                    <div class="col-6">
                                        <label>Campo</label>
                                        <select class="form-control" :value="filters.sort.field" @change="filters.sort.field=$event.target.value ">
                                            <option :value="''">--</option>
                                            <option value="nombre_real">Nombre</option>
                                            <option value="created_at">Fecha creación</option>
                                            <option value="extension">Extension</option>
                                            <option value="size">Tamaño</option>
                                        </select>
                                    </div>
                                     <div class="col-6">
                                        <label>Forma</label>
                                        <select class="form-control" :value="filters.sort.type" @change="filters.sort.type=$event.target.value">
                                            <option value="asc">Ascendente</option>
                                            <option value="desc">Descendente</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-12">
                                        <h5>Calidad Imagen</h5>
                                        <hr>
                                    </div>
                                    <hr>
                                    <div class="col-5">
                                        <label>Ancho</label>
                                        <select class="form-control" :value="filters.widthHeight.width" @change="filters.widthHeight.width=$event.target.value ">
                                            <option :value="''">--</option>
                                            <option value="144">144</option>
                                            <option value="240">240</option>
                                            <option value="360">360</option>
                                            <option value="480">480</option>
                                            <option value="720">720</option>
                                            <option value="1080">1080</option>
                                            <option value="1920">1920</option>
                                        </select>
                                    </div>
                                    <div class="col-1 text-center align-self-end align-item-bottom">
                                        <label>x</label>
                                    </div>
                                    <div class="col-5">
                                        <label>Alto</label>
                                        <select class="form-control" :value="filters.widthHeight.height" @change="filters.widthHeight.height=$event.target.value ">
                                            <option :value="''">--</option>
                                            <option value="144">144</option>
                                            <option value="240">240</option>
                                            <option value="360">360</option>
                                            <option value="480">480</option>
                                            <option value="720">720</option>
                                            <option value="1080">1080</option>
                                            <option value="1920">1920</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row d-flex justify-content-center">
                                    <gif-loading style="position:fixed; right:70px; z-index:2;" :show="labelButtonAdvancedSearching === 'Buscando ..' ? true : false"></gif-loading>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary w-100" @click="buscar"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                            <!-- Filters Box  (end)-->
                        </transition>
                      </div>
                    </div>
                    <div class=" rounded bg-primary p-3 sombra"  v-if="busqAv"  style="position:absolute;z-index:3;width:100%;">
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
                <div class="col-lg-4 col-md-12 col-sm-12  my-2" v-for="(file,index) in foundFiles['data']" :key="file+index">
                    <fichero-miniatura
                    :fichero_param="file"
                    :root_dir="root_dir"
                    :index="index"
                    :operating="operating"

                    @operating="operating = true"
                    @operation_done="getOperation"></fichero-miniatura>
                <!-- {{file.nombre_real}} -->
                </div>
            </div>
        </div>
        <!-- Load More button -->
        <div class="container" v-if="currentPage < foundFiles['last_page']">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <button @click="loadMore" class="btn btn-sm btn-primary w-100">Cargar mas..</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style>

    .fixed-right{
        position: fixed;
        right: 0;
        z-index: 1;
    }

    #filters_box{
        position: fixed;
        width: 300px;
        height:600px;
        overflow-y: scroll;
        right:35px;
        bottom:10px;
        z-index: -1;
         /* style="max-height:200px; overflow-y:scroll;" */

    }


/* toggle buton filters */

#toggle_button_filters{
    background-color:  #4600bf;
    float:right;
    bottom: 0;
    right:0;
    position: fixed;
}

    /* --- */
    /* VUEJS ANIMATIONS */
    /* --- */
    /* Las animaciones de entrada y salida pueden usar */
    /* funciones de espera y duración diferentes.      */
    .slide-fade-enter-active {
        transition: all .2s ease;
    }
    .slide-fade-leave-active {
        transition: all .1s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
    /* .slide-fade-leave-active below version 2.1.8 */ {
        transform: translateX(10px);
        opacity: 0;
    }

</style>

<script>
    export default {
        props:['root_dir'],
        data(){
            return{
                fileNameToFind:'',
                busqAv:false,
                foundFiles:[],
                labelButtonAdvancedSearching:'Busqueda Avanzada',
                currentPage:1,
                lastPage:1,
                operating:false,

                //advanced searching tools
                show:{
                    tog_but_adv_sear:false
                },

                //needed data to advanced searching tools about user info
                //'data loadeed from server'
                filters:{
                    extensions:[], //all avaliabled extensions
                    selectedExtensions:[],//all selected extension
                    sort:{field:'',type:'desc'},
                    widthHeight:{width:'',height:''}

                }
            }
        },
        methods:{
            buscar(reset = true){
                this.labelButtonAdvancedSearching = 'Buscando ..';
                let that = this;
                let data = new FormData();
                data.append('file_name_to_find',this.fileNameToFind);
                data.append('filters',JSON.stringify(this.filters));

                if (reset) {
                    this.currentPage = 1;
                }
                else{
                    this.currentPage++;
                }

                 axios.post('/file/advanced_searching?page='+this.currentPage,data).then(
                    (response) => {
                        if (reset) {
                            console.log('[reset]');
                            that.foundFiles = response.data.result;
                        } else {
                            console.log('[append]');
                            response.data.result['data'].forEach(element => {
                                that.foundFiles['data'].push(element);
                            });
                        }

                        that.labelButtonAdvancedSearching = 'Busqueda Avanzada';
                    },
                    error=>{
                        console.log('Error al hacer la busqueda avanzada');
                        that.labelButtonAdvancedSearching = 'Busqueda Avanzada';
                    }
                )
            },
            loadMore(){
                this.buscar(false);
            },
            getOperation(value){

                //deleting file...
                if (Number.isInteger(value)) {
                   this.foundFiles['data'].splice(value, 1);
                }
                this.operating = false;
            },
            applyFilters(){
                console.log('Selected filters !');
                console.log('____________');

                console.log('extensions');
                console.log(this.filters.selectedExtensions);

                console.log('sort');
                console.log(this.filters.sort);

                console.log('width - height');
                console.log(this.filters.widthHeight);
            }
        },

    }
</script>


