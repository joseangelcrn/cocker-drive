<template>
    <div class="row d-fle justify-content-center">
        <div class="col-10 bg-white p-3 rounded">
            <gif-loading style="position:absolute; left:0; z-index:1" :show="loading"></gif-loading>
            <data-table
                :columns="columns"
                :per-page="[10,20,50,100]"
                :order-by="'created_at'"
                :order-dir="'desc'"
                url="/log/searching"
                :translate="{ nextButton: 'Siguiente', previousButton: 'Anterior', placeholderSearch: 'Buscar'}"
                :filters="filters"
                @loading="loading = true"
                @finished-loading ="loading = false"
                >
                    <div slot="filters" slot-scope="{ tableData, perPage }">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <select class="form-control" v-model="tableData.length">
                                <option :key="page" v-for="page in perPage">{{ page }}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select

                                v-model="tableData.filters.logType"
                                class="form-control"
                                :class="
                                {
                                'bg-white text-dark': '',
                                'bg-success text-white': tableData.filters.logType === 'uploaded',
                                'bg-warning text-dark': tableData.filters.logType === 'renamed',
                                'bg-danger  text-white': tableData.filters.logType === 'deleted',

                                }"
                                >
                                <option class="bg-white  text-dark  " value>Todos</option>
                                <option class="bg-success text-white" value='uploaded'>Subidas</option>
                                <option class="bg-warning  text-dark    " value='renamed'>Renombraciones</option>
                                <option class="bg-danger text-white" value='deleted'>Eliminaciones</option>

                            </select>
                        </div>
                        <div class="col-md-4">
                            <input
                                name="name"
                                class="form-control"
                                v-model="tableData.search"
                                placeholder="Nombre archivo">
                        </div>
                    </div>
                </div>
            </data-table>


        </div>
    </div>
</template>

<style lang="scss">
</style>

<script>


    export default
    {
        data ()
        {
            return {
                loading:false,
                filters:{
                    logType:''
                },
               columns: [
                    {
                        label: 'ID',
                        name: 'id',
                        orderable: true,
                    },
                    {
                        label: 'Nombre archivo actual',
                        name: 'file.nombre_real',
                        orderable: true,
                    },
                    {
                        label: 'Tipo',
                        name: 'type.name',
                        orderable: false,
                    },
                    {
                        label: 'Nombre antiguo',
                        name: 'old_name',
                        orderable: true,
                    },{
                        label: 'Nombre nuevo',
                        name: 'new_name',
                        orderable: true,
                    },{
                        label: 'Fecha',
                        name: 'created_at',
                        orderable: true,
                    },
                ],
            }
        }
    }
</script>
