<template>
<app-layout>
      <div class="container-fluid">
        <div class="flex justify-between">
          <div class=" flex items-end my-1">
            <div class="mr-2">
              <select class="block w-full bg-white border border-gray-400 hover:border-gray-500 rounded shadow leading-tight focus:outline-none focus:shadow-outline" v-model="tableData.length" @change="getroles()">
                  <option v-for="(records, index) in perPage" :key="index" :value="records">{{records}}</option>
              </select>
            </div>
              <div v-if="$page.props.permisos.includes('Crear-roles')" class="w-auto mr-1">
                <a class="flex items-center p-2 text-white bg-green-500 rounded select-none no-outline focus:shadow-outline" :href="route('roles.create')">
                  <i class="pi pi-plus-circle"></i>
                  <span class="hidden md:block pl-2"> Crear</span>
                </a>
              </div>
              <div v-if="$page.props.permisos.includes('Exportar-roles')" class="w-auto">
               <!-- modal -->
                <div class=" cursor-pointer flex items-center p-2 text-white bg-blue-500 rounded select-none no-outline focus:shadow-outline" @click="showModal = true">
                  <i class="pi pi-download"></i> 
                  <span class="hidden md:block pl-2"> Exportar </span>
                </div>
                 <ModalExportar url="exportar-roles" v-if="showModal" @close="showModal = false" :tableData="tableData"/>
              </div> 

              </div>

            <fieldset class="border p-1">
              <legend class="w-auto my-0" ><span class="my-0 text-sm"> Buscar por</span></legend>
              <div class="flex items-center">
                <div class="pr-1">
                <input class="bg-white h-8 px-3 pr-10 border border-gray-300 rounded-full text-sm focus:outline-none w-32 md:w-64 " autofocus type="text" v-model="tableData.search" placeholder="Buscar"
                    @keyup.enter="getroles()">
                </div>
                <div class="pl-1">
                <select class="block w-full bg-white border border-gray-400 hover:border-gray-500 px-2 pr-4 rounded shadow leading-tight focus:outline-none focus:shadow-outline" v-model="tableData.searchColumn">
                    <option value="name" selected> Nombre </option>
                    <option value="description">Descripción</option>
                    <option value="category">Categoria</option>
                </select>
                </div>
              </div>
            </fieldset>
          </div>

        </div>
        <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
            <tbody>
                <tr class="h-8 " v-for="rol in roles" :key="rol.id">
                    <td style="width: 30%">{{rol.name}}</td>
                    <td style="width: 45%">{{rol.description}}</td>
                    <td style="width: 25%">{{rol.category}}</td>
                    <td v-if="$page.props.permisos.includes('Ver-roles')">
                      <div class="flex justify-center">
                        <a class="bg-blue-600 rounded p-2 text-white" :href="'/roles/'+rol.id"><i class="pi pi-eye"></i></a>
                      </div>
                    </td>
                    <td v-if="$page.props.permisos.includes('Editar-roles')">
                      <div class="flex justify-center">
                        <a class="bg-yellow-300 p-2 rounded" :href="'/roles/'+rol.id+'/edit'"><i class="pi pi-pencil"></i></a>
                      </div>
                    </td>
                    <td v-if="$page.props.permisos.includes('Eliminar-roles')">
                      <div class="flex justify-center">
                        <a class="cursor-pointer  text-white bg-red-600 p-2 rounded my-1" @click="borrar(rol.id)"><i class="pi pi-trash"></i></a>
                      </div>
                    </td>
                </tr>
            </tbody>
        </datatable>

        <!-- <ModalEliminar :url="url" v-if="modaleliminar" @eliminado="metodo" @close="modaleliminar = false" />
         -->
         <ConfirmDialog></ConfirmDialog>

        <div class="d-flex justify-content-end">
          <pagination :pagination="pagination"
                      @prev="getroles(pagination.prevPageUrl)"
                      @next="getroles(pagination.nextPageUrl)">
          </pagination>
        </div>
  </app-layout>
</template>

<script>

import AppLayout from '@/Layouts/AppLayout'
import Datatable from '@/Pages/Tabla';
import Pagination from '@/Pages/Pagination';
import ModalExportar from '@/Pages/ModalExportar';
import ConfirmDialog from 'primevue/confirmdialog';
export default {
    components: { datatable: Datatable, pagination: Pagination, ModalExportar, AppLayout, ConfirmDialog},
    created()
      {
      this.getroles();
    },
    data() {
      let sortOrders = {};
      let columns = [
          {label: 'Nombre', name: 'name' },
          {label: 'Descripcion', name: 'description'},
          {label: 'Categoria', name: 'category'}
      ];
      var columnasPrincipales = columns.length - 1 ;
      columns.forEach((column) => {
          sortOrders[column.name] = -1;
      });
      if(this.$page.props.permisos.includes('Ver-roles')){
        columns.push({label: 'Ver', name: 'ver'});
      }
      if(this.$page.props.permisos.includes('Editar-roles')){
        columns.push({label: 'Editar', name: 'editar'});
      }
      if(this.$page.props.permisos.includes('Eliminar-roles')){
        columns.push({label: 'Eliminar', name: 'eliminar'});
      }
      return {
        
        roles: [],
        exportar: 'excel',
        showModal: false,
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
            searchColumn:'name',
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
      borrar(info) {
            this.$confirm.require({
                header: 'Confirmacion',
                message: 'Esta seguro que desea eliminar este registro?',
                acceptLabel: 'Si',
                icon: 'pi pi-exclamation-triangle',
                accept: () => {
                  this.$inertia.delete('roles/'+info, {
        
                    onSuccess : () => {
                      
                      if(this.$page.props.flash.mensaje){
                        let datos = this.$page.props.flash.mensaje
                        this.$toast.add({severity:datos.type, summary: datos.title, detail:datos.message, life:5000});
                         this.getroles();
                      }
                    },
                  })
                },
                reject: () => {
                    //callback to execute when user rejects the action
                }
            });
        },
      getroles(url = '/obtenerroles') {
        this.tableData.draw++;
        axios.get(url, {params: this.tableData})
        .then(response => {
          let data = response.data;
          this.parametrostabla = data;
          if (this.tableData.draw == data.draw) {
            this.roles = data.data.data;
            this.configPagination(data.data);
          }
        })
        .catch(errors => {
          this.$toast.add({severity:'error', summary: 'Error', detail:'Al obtener roles', life:5000});
        });
      },
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
          this.getroles();
        },
        getIndex(array, key, value) {
          return array.findIndex(i => i[key] == value)
        },

    }
};

</script>