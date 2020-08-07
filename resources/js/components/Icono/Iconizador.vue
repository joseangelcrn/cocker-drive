<template>
    <div>
        <!-- Si es Imagen pongo su imagen preview -->
        <div v-if="extImagenesPermitidas.includes(fichero.extension)" class="text-center">
            <img style="height:250px;" class="img-thumbnail w-100" :src="'../storage/ficheros/'+fichero.nombre_hash" alt="Imagen">
        </div>

        <!-- Si es PDF: Icono PDF -->
        <div v-else-if="fichero.extension == 'pdf'" class="text-center">
            <img style="height:250px;" class="img-thumbnail w-100" :src="'../storage/sistema/iconos/pdf.svg'" alt="Icono PDF">
        </div>

        <!-- Si es Doc/Docx: Icono Doc -->
        <div v-else-if="extDocs.includes(fichero.extension)" class="text-center">
            <img style="height:250px;" class="img-thumbnail w-100" :src="'../storage/sistema/iconos/doc.jpg'" alt="Icono PDF">
        </div>

        <!-- Si es TXT:  Icono Txt -->
        <div v-else-if="fichero.extension == 'txt'" class="text-center">
            <img style="height:250px;" class="img-thumbnail w-100" :src="'../storage/sistema/iconos/txt.png'" alt="Icono TXT">
        </div>

    </div>
</template>

<script>
    export default {
        props:['fichero_param'],
        data(){
            return{
                fichero:null,
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
            }
        },
        beforeMount() {
            this.fichero = this.$props.fichero_param;
        }
    }
</script>
