<template>
    <div>
       <img class="img-fluid" style="height:40px; width:40px;"  v-if="show" :src="src" alt="Gif loading">
    </div>
</template>

<script>
    export default {
         props:
        {
            'show':{
                type:Boolean,
                default:false
            }
        },
        data(){
            return{
                src:'../storage/sistema/gifs/loading-dog.gif'
            }
        },
        beforeMount() {
            this.fichero = this.$props.fichero_param;
        }
    }
</script>
