<template>
    <div class="card" style="width: 18rem;"  title="">
        <a id="imagen" :href="'/fichero/'+fichero_param.id" target="_blank">
            <iconizador  :fichero_param="fichero_param" :root_dir="root_dir" ></iconizador>
        </a>
        <div class="card-body">
            <h6  v-if="!editableName" class="card-title" style="overflow-x: scroll; height:50px;">{{fichero_param.nombre_real}}</h6>
            <input  v-if="editableName" class="form-control-sm" v-model="newName" >

            <!-- Renombrar - Borrar -->
            <div id="botonera" v-if="!editableName && !deletableFile">
                <button :disabled="operating" @click="editableName = true; newName=fichero_param.nombre_real" class="btn btn-sm btn-warning">Renombrar</button>
                <button :disabled="operating" @click="deletableFile = true" class="btn btn-sm  btn-danger">Borrar</button>
            </div>

            <!-- OK - Cancelar -->
            <div v-else class="mt-3">
                <button :disabled="operating" @click="renameOrDelete" class="btn btn-sm btn-success">OK</button>
                <button :disabled="operating" @click="editableName = false; deletableFile = false" class="btn btn-sm btn-danger">Cancelar</button>
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
            },
            'operating':{
                type:Boolean,
                default:false
            },
            'index':{
                type:Number
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
                this.$emit('operating',true);

                if (this.editableName) {
                    this.rename();
                } else {
                    this.delete();
                }
            },
            rename(){
                // console.log(this.fichero);
                let data = new FormData();
                data.append('file',this.$props.fichero_param);
                data.append('new_name',this.newName);
                data.append('_method','patch');

                console.log('new name = '+this.newName);
                let that = this;
                axios.post('/fichero/'+this.$props.fichero_param.id, data).then(
                    response => {
                        let data = response.data;

                        if (data.result === true) {
                            // that.fichero = data.file
                            console.log('that.newName = '+that.newName);
                            that.$props.fichero_param.nombre_real = that.newName;
                            that.editableName = false;
                            that.$emit('operation_done',true);
                        }
                    },
                    error=>{
                        console.log('Error on remane file.');
                    }
                )
            },
            delete(){
                console.log('delete !');
                let that = this;

                axios.delete('/fichero/'+this.$props.fichero_param.id).then(
                    response => {
                        console.log('response.data');
                        console.log(response.data);
                        let data = response.data;

                         console.log('enviar evento');
                        that.$emit('operation_done',that.$props.index);

                    },
                    error=>{
                        that.$emit('deleted','error');
                        console.log('Error al actualizar el nombre de la imagen');
                    }
                )
            }
        },
         beforeMount() {
                // this.fichero = this.$props.fichero_param;
                this.newName = this.fichero.nombre_real;
            }
    }
</script>


