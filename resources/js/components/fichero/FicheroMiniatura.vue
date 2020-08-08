<template>
    <div class="card" style="width: 18rem;" :style="[hover ? estilosHover : {}]"  @mouseover="hover=true" @mouseleave="hover=false" title="loremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremlorem">
        <iconizador :fichero_param="fichero"></iconizador>
        <div class="card-body">
            <h6 class="card-title" style="overflow-x: scroll; height:50px;">{{fichero.nombre_real}}</h6>
            <a :href="'/fichero/'+fichero.id" class="btn btn-primary" target="_blank">Ver</a>
            <a :href="'/fichero/'+fichero.id+'/edit'" class="btn btn-warning">Editar</a>
            <a href="#" class="btn btn-danger">Borrar</a>
        </div>
    </div>
</template>

<script>
    export default {
        props:['fichero_param'],
        data(){
            return{
                fichero:null,
                hover: false,
                estilosHover:{
                    'box-shadow':'30px 1px 5px blue',
                    'width':'80%','transition':'0.5s',
                    'border-bottom-right-radius':'30%',
                    // 'cursor': 'pointer'
                }
            }
        },
        methods:{
        },
        beforeMount() {
            this.fichero = JSON.parse(this.$props.fichero_param);
        }
    }
</script>


