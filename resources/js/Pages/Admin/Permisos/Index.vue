<template>
<app-layout>
        <div class="container-fluid">
            <div class="flex justify-between">
                <div class="flex items-end">
                    <div class="mr-2">
                <select class="block w-full bg-white border border-gray-400 hover:border-gray-500 rounded shadow leading-tight focus:outline-none focus:shadow-outline" v-model="tableData.length" @change="getpermisos()">
                          <option v-for="(records, index) in perPage" :key="index" :value="records">{{records}}</option>
                      </select>
                    </div>
                </div>

                <fieldset class="border p-1">
                  <legend class="w-auto my-0" ><span class="my-0 text-sm"> Buscar por</span></legend>
                  
                  <div class="flex items-center">
                    <div class="pr-1">

                    <input class="bg-white border border-gray-300 h-8 px-3 pr-10 rounded-full text-sm focus:outline-none w-32 md:w-64 " autofocus type="text" v-model="tableData.search" placeholder="Buscar"
                        @keyup.enter="getpermisos()">
                    </div>
                    <div class="pl-1">

                    <select class="block w-full bg-white border border-gray-400 hover:border-gray-500 px-2 pr-4 rounded shadow leading-tight focus:outline-none focus:shadow-outline" v-model="tableData.searchColumn">
                        <option value="category">Categoria</option>
                        <option value="name">Nombre permiso</option>
                        <option value="description">Descripción</option>
                    </select>
                    </div>
                  </div>
                </fieldset>
            </div>

        </div>
        <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
            <tbody >
                <tr v-for="permiso in permisos" :key="permiso.id">
                    <td style="width: 20%">{{permiso.category}}</td>
                    <td style="width: 20%">{{permiso.name}}</td>
                    <td style="width: 60%">{{permiso.description}}</td>
                </tr>
            </tbody>
        </datatable>
        <div class="d-flex justify-content-end">
          <pagination :pagination="pagination"
                      @prev="getpermisos(pagination.prevPageUrl)"
                      @next="getpermisos(pagination.nextPageUrl)">
          </pagination>
      </div>

</app-layout>
</template>

<script>

import AppLayout from '@/Layouts/AppLayout'
import Datatable from '@/Pages/Tabla';
import Pagination from '@/Pages/Pagination';
export default {
    components: { datatable: Datatable, pagination: Pagination, AppLayout},
    created() {
        this.getpermisos();
    },
    data() {
        let sortOrders = {};
        let columns = [
            {label: 'Categoria', name: 'category'},
            {label: 'Nombre', name: 'name' },
            {label: 'Descripcion', name: 'description'},
        ];
        var columnasPrincipales = columns.length - 1 ;
        columns.forEach((column) => {
           sortOrders[column.name] = -1;
        });
        return {
            permisos: [],
            columns: columns,
            columnasPrincipales:columnasPrincipales,
            sortKey: '',
            sortOrders: sortOrders,
            perPage: ['15', '30', '50'],
            tableData: {
                draw: 0,
                length: 15,
                search: '',
                column: 0,
                dir: 'asc',
                searchColumn:'category',
            },
            pagination: {
                lastPage: '',
                currentPage: '',
                total: '',
                lastPageUrl: '',
                nextPageUrl: '',
                prevPageUrl: '',
                from: '',
                to: ''
            },
        }
    },
    methods: {
        getpermisos(url = '/obtenerpermisos') {
            this.tableData.draw++;
            axios.get(url, {params: this.tableData})
                .then(response => {
                    let data = response.data;
                    this.parametrostabla = data;
                    if (this.tableData.draw == data.draw) {
                        this.permisos = data.data.data;
                        this.configPagination(data.data);
                    }
                })
                .catch(errors => {
                    this.$toast.add({severity:'error', summary: 'Error', detail:'Al obtener permisos', life:5000});
                });
        },
        // eliminarpermiso(permisosid) {
        //     this.tableData.draw++;
        //     axios.delete('/permisos/'+permisoid, {params: this.tableData})
        //         .then(response => {
        //             let data = response.data;
        //             this.parametrostabla = data;
        //             if (this.tableData.draw == data.draw) {
        //                 this.permisos = data.data.data;
        //                 this.configPagination(data.data);
        //             }
        //         })
        //         .catch(errors => {
        //             console.log(errors);
        //         });
        // },
        configPagination(data) {
            this.pagination.lastPage = data.last_page;
            this.pagination.currentPage = data.current_page;
            this.pagination.total = data.total;
            this.pagination.lastPageUrl = data.last_page_url;
            this.pagination.nextPageUrl = data.next_page_url;
            this.pagination.prevPageUrl = data.prev_page_url;
            this.pagination.from = data.from;
            this.pagination.to = data.to;
        },
        sortBy(key) {
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
            this.tableData.column = this.getIndex(this.columns, 'name', key);
            this.tableData.dir = this.sortOrders[key] === 1 ? 'asc' : 'desc';
            if(this.tableData.column <= this.columnasPrincipales)
            this.getpermisos();
        },
        getIndex(array, key, value) {
            return array.findIndex(i => i[key] == value)
        },

    }
};
</script>