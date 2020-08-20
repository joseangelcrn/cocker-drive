<template>
    <div class="container">
        <div class="row ">
            <div class="col-12 text-center">
                <a :disabled="loading"  :class="{'disabled':loading}" :href="url_list_files" class="btn btn-secondary" @click="loading=true" title="Ver mis archivos"><i class="fas fa-list"></i></a>
                <a :disabled="loading"  :class="{'disabled':loading}"  :href="url_upload_files" class="btn btn-success" @click="loading=true" title="Subir archivos"><i class="fas fa-cloud-upload-alt"></i></a>
                <a :disabled="loading" :class="{'disabled':loading}"  @click.prevent="downloadCompressedFiles" class="btn btn-warning"  title="Descargar todos los archivo en carpeta comprimida."><i class="far fa-file-archive"></i></a>
                <a   :disabled="loading" :class="{'disabled':loading}"   @click.prevent="deleteAllFiles" class="btn btn-danger"  title="Borrar todos los archivos.">
                    <i class="fas fa-folder-open"></i>
                    <i class="fas fa-dumpster"></i>
                </a>
            </div>
            <div class="col-12">
                <gif-loading style="position:fixed; top: 45%;left: 45%; top:30%; z-index:2;" :show="loading"></gif-loading>
            </div>
            <div class="col-12 text-center">
                <chart-donut class="my-4" :size_disk_used="size_disk_used" :data_param="data"></chart-donut>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:[
            'size_disk_used',
            'data',
            'url_list_files',
            'url_upload_files',
            'url_download_all_compressed_files',
            'url_delete_all'
        ],
        data(){
            return{
                loading:false
            }
        },
        methods:{
            downloadCompressedFiles(){
                this.loading = true;
                let that = this;

                //creating current date
                let date = new Date()

                let day = date.getDate();
                let month = date.getMonth() + 1;
                let year = date.getFullYear();

                let fullDate ='';
                if(month < 10){
                    fullDate = `${day}-0${month}-${year}`;
                }else{
                    fullDate = `${day}-${month}-${year}`;
                }
                fullDate = fullDate.toString();

                axios.get(this.$props.url_download_all_compressed_files, { responseType: 'blob' })
                    .then(response => {
                        const blob = new Blob([response.data], { type: 'application/zip' })
                        const link = document.createElement('a');
                        link.href = URL.createObjectURL(blob);
                        link.download = "cocker-drive_mis_archivos_"+fullDate;
                        link.click();
                        URL.revokeObjectURL(link.href);
                        that.loading = false;
                    }).catch((error)=>{
                        console.log('Error !');
                        console.log(error);
                    })
            },
            deleteAllFiles(){
                let that = this;
                    this.$confirm(
                            {
                            title:`¿Deseas eliminar todos los archivos subidos?`,
                            message: `Una vez borrados no los podras recuperar. Te aconsejamos hacer una copia de los archivos previamente`,
                            button: {
                                no: 'No',
                                yes: 'Si'
                            },
                            /**
                             * Callback Function
                             * @param {Boolean} confirm
                             */
                            callback: confirm => {
                                if (confirm) {
                                  this.$confirm(
                                    {
                                    title: `¿Estas seguro/a?`,
                                    button: {
                                        no: 'No',
                                        yes: 'Si'
                                    },
                                    /**
                                     * Callback Function
                                     * @param {Boolean} confirm
                                     */
                                    callback: confirm => {
                                        if (confirm) {
                                            that.loading = true;
                                            axios.delete(this.$props.url_delete_all).
                                            then(response => {
                                                    console.log('response.data');
                                                    console.log(response.data);
                                                    let data = response.data;
                                                    that.loading = false;

                                                },
                                                error=>{
                                                    console.log('Error al actualizar el nombre de la imagen');
                                                    that.loading = false;

                                                }
                                            )

                                        }
                                        else{
                                            that.loading = false;
                                        }

                                    }
                                }
                            );
                                }
                                //enbale buttons again
                                else{
                                   that.loading = false;
                                }

                            }
                            }
                        );
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
