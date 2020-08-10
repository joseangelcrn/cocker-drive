<template>
    <div>
       <img class="img-fluid" style="height:40px; width:40px;"  v-if="show" :src="'../storage/sistema/gifs/loading-dog.gif'" alt="Gif loading">
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
            }
        },
        beforeMount() {
            this.fichero = this.$props.fichero_param;
        }
    }
</script>
