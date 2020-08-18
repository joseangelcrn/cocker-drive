<template>
    <div>
      <!-- Si es Imagen pongo su imagen preview -->
        <div v-if="extensions.image.includes(fichero.extension)" class="text-center sombra">
            <img v-if="creating" style="height:250px;" class="img-thumbnail" :src="fichero.url" alt="fichero">
            <img v-else style="height:250px;" class="img-thumbnail" :src="'../storage/ficheros/'+root_dir+'/'+fichero.nombre_hash" alt="fichero">
        </div>
        <!-- Si es PDF: Icono PDF -->
        <div v-else-if="fichero.extension == 'pdf'" class="text-center sombra">
            <img style="height:250px;" class="img-thumbnail" :src="'../storage/sistema/iconos/pdf.svg'" alt="Icono PDF">
        </div>
        <!-- Si es Doc/Docx: Icono Doc -->
        <div v-else-if="extensions.document.includes(fichero.extension)" class="text-center sombra">
            <img style="height:250px;" class="img-thumbnail" :src="'../storage/sistema/iconos/doc.jpg'" alt="Icono PDF">
        </div>
        <!-- Si es TXT:  Icono Txt -->
        <div v-else-if="fichero.extension == 'txt'" class="text-center sombra">
            <img style="height:250px;" class="img-thumbnail" :src="'../storage/sistema/iconos/txt.png'" alt="Icono TXT">
        </div>
        <!-- Si es Musica -->
        <div v-else-if="extensions.music.includes(fichero.extension)" class="text-center sombra">
            <img style="height:250px;" class="img-thumbnail" :src="'../storage/sistema/iconos/music.png'" alt="Icono MUSIC">
        </div>
        <!-- Si es Video -->
        <div v-else-if="extensions.video.includes(fichero.extension)" class="text-center sombra">
            <img style="height:250px;" class="img-thumbnail" :src="'../storage/sistema/iconos/video.png'" alt="Icono VIDEO">
        </div>
        <!-- Si es Compressed File -->
        <div v-else-if="extensions.compressed.includes(fichero.extension)" class="text-center sombra">
            <img style="height:250px;" class="img-thumbnail" :src="'../storage/sistema/iconos/compressed.png'" alt="Icono VIDEO">
        </div>

    </div>
</template>

<script>
    export default {
         props:
        {
            'fichero':{
                default:{}
            },
            'root_dir':{
                type:String,
                default:''
            },
            'creating':{
                type:Boolean,
                default:false
            }
        },
        data(){
            return{
                extensions:{
                    image:[
                        'png',
                        'jpg',
                        'jpeg',
                    ],
                    music:[
                        'mp3',
                    ],
                    document:[
                        'docs',
                        'doc',
                        'docx',
                    ],
                    video:[
                        'avi',
                        'mp4',
                        'mov'
                    ],
                    compressed:[
                        'rar',
                        'zip',
                        'qt'
                    ]
                },
            }
        },
        beforeMount() {

        }
    }
</script>
