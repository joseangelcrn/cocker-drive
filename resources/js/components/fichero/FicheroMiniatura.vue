<template>
    <div class="card" style="width: 18rem;"  title="">
        <a id="imagen" :href="'/fichero/'+fichero.id" target="_blank">
            <iconizador  :fichero_param="fichero" :root_dir="root_dir" ></iconizador>
        </a>
        <div class="card-body">
            <h6  v-if="!editableName" class="card-title" style="overflow-x: scroll; height:50px;">{{fichero.nombre_real}}</h6>
            <input  v-if="editableName" class="form-control-sm" v-model="newName" >

            <!-- Renombrar - Borrar -->
            <div id="botonera" v-if="!editableName && !deletableFile">
                <button @click="editableName = true" class="btn btn-sm btn-warning">Renombrar</button>
                <button @click="deletableFile = true" class="btn btn-sm  btn-danger">Borrar</button>
            </div>

            <!-- OK - Cancelar -->
            <div v-else class="mt-3">
                <button @click="renameOrDelete" class="btn btn-sm btn-success">OK</button>
                <button @click="editableName = false; deletableFile = false; newName=fichero.nombre_real" class="btn btn-sm btn-danger">Cancelar</button>
            </div>
        </div>
    </div>
</template>

<style scoped>
    #imagen :hover{
        box-shadow:'30px 1px 5px blue';
        width:'80%';
        transition:0.5s;
        border-bottom-right-radius:30%;
        border: red  10px;

    }
</style>

<script>
    export default {
        props:
        {
            'fichero_param':{
                type:Object,
                default:{
                    nombre_real:'error'
                }
            },
            'root_dir':{
                type:String,
                default:''
            }
        },
        data(){
            return{
                fichero:{},
                editableName:false,
                deletableFile:false,
                newName:''
            }
        },
        methods:{
            renameOrDelete(){
                let config = {
                    header : {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                }

                if (this.editableName) {
                    this.rename();
                } else {
                    this.delete();
                }
            },
            rename(){
                // console.log(this.fichero);
                let data = new FormData();
                data.append('file',this.fichero);
                data.append('new_name',this.newName);
                data.append('_method','patch');

                console.log('new name = '+this.newName);
                let that = this;
                axios.post('/fichero/'+this.fichero.id, data).then(
                    response => {
                        console.log('response.data');
                        console.log(response.data);
                        let data = response.data;

                        if (data.result === true) {
                            that.fichero = data.file
                            that.editableName = false;
                        }
                    },
                    error=>{
                        console.log('Error al actualizar el nombre de la imagen');
                    }
                )
            },
            delete(){
                console.log('delete !');
                axios.delete('/fichero/'+this.fichero.id).then(
                    response => {
                        console.log('response.data');
                        console.log(response.data);
                        let data = response.data;

                    },
                    error=>{
                        console.log('Error al actualizar el nombre de la imagen');
                    }
                )
            }
        },
         beforeMount() {
                this.fichero = this.$props.fichero_param;
                this.newName = this.fichero.nombre_real;
            }
    }
</script>


