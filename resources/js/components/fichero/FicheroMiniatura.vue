<template>
    <div class="card" style="width: 18rem;"  title="">
        <a id="imagen" :href="'/fichero/'+fichero_param.id" target="_blank">
            <iconizador  :fichero="fichero_param" :root_dir="root_dir" :creating="false"></iconizador>
        </a>
        <div class="card-body">
            <h6  v-if="!editableName" class="card-title" style="overflow-x: scroll; height:50px;">{{fichero_param.nombre_real}}.{{fichero_param.extension}}</h6>
            <input  v-if="editableName" class="form-control-sm mb-4" v-model="newName" >

            <h6 class="card-title">{{fichero_param.width}}x{{fichero_param.height}}</h6>
            <h6 class="card-title">{{(fichero_param.size / (1024*1024)).toFixed(2)}} MB</h6>

            <!-- Rename - Delete -->
            <div class="row d-flex justify-content-between" id="botonera" v-if="!editableName" >
                <button class="btn btn-warning" :disabled="operating" @click="editableName = true; newName=fichero_param.nombre_real" title="Editar el nombre de archivo"><i class="fas fa-edit"></i></button>
                <button class="btn btn-success" :disabled="operating" @click="download" title="Descargar archivo"><i class="fas fa-download"></i></button>
                <button class="btn btn-danger" :disabled="operating" @click="renameOrDelete(2)" title="Eliminar archivo" ><i class="fa fa-trash" aria-hidden="true"></i></button>
            </div>

            <!-- OK - Cancel -->
            <div v-else class="mt-3">
                <button :disabled="operating" @click="renameOrDelete(1)" class="btn btn-success"><i class="fas fa-check"></i></button>
                <button :disabled="operating" @click="editableName = false;" class="btn btn-danger"><i class="fas fa-times"></i></button>
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
            'fichero_param':{ //object with information to display data (file information)
                type:Object,
                default:{
                    nombre_real:'error'
                }
            },
            'root_dir':{ //root dir where is doing the searching
                type:String,
                default:''
            },
            'operating':{ //mean this component is renaming/deleting file
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
            renameOrDelete(option){
                //option = 1 -> renaming
                //option = 2 -> deleting

                this.$emit('operating',true);
                if (option === 1) {
                    this.rename();
                } else {
                    let that = this;
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
                                    this.delete();
                                }
                                //enbale buttons again
                                else{
                                    that.$emit('operation_done',false);
                                }

                            }
                            }
                        );
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
            },
            download(){
                window.location.href = "file/download-single-file?file_id="+this.$props.fichero_param.id;
            }
        },
         beforeMount() {
                this.newName = this.fichero.nombre_real;
            }
    }
</script>


