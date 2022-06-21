<template>
   <app-layout>
        <div class="container-fluid">
          <div class="flex justify-between">
            <div class="flex items-end my-1">
              <div class="mr-2">
                <select class="block md:w-full bg-white border border-gray-400 hover:border-gray-500 w-12 rounded shadow leading-tight focus:outline-none focus:shadow-outline" v-model="tableData.length" @change="getUsuarios()">
                  <option v-for="(records, index) in perPage" :key="index" :value="records">{{records}}</option>
                </select>
              </div>
                <div v-if="$page.props.permisos.includes('Crear-usuarios')" class="w-auto mr-1">
                  <a class="flex items-center p-2 text-white bg-green-500 rounded select-none no-outline focus:shadow-outline" href="/users/create">
                    <i class="pi pi-plus-circle"></i>
                    <span class="hidden md:block pl-2">Crear</span>
                  </a>
                </div>
                <div v-if="$page.props.permisos.includes('Exportar-usuarios')" class="w-auto">
                  <div class=" cursor-pointer flex items-center p-2 text-white bg-blue-500 rounded select-none no-outline focus:shadow-outline" @click="showModal=!showModal">
                    <i class="pi pi-download"></i> 
                    <span class="hidden md:block pl-2"> Exportar </span>
                  </div>
                  <ModalExportar url="exportar-usuarios" v-if="showModal" @close="showModal = false" :tableData="tableData"/>

                </div>
            </div>
            <fieldset class="border p-1">
              <legend class="w-auto my-0" ><span class="my-0 text-sm"> Buscar por</span></legend>
              <div class="flex items-center">
                <div class=" pr-1">
                <input class="bg-white h-8 px-3 pr-10 rounded-full text-sm focus:outline-none w-32 md:w-64 " autofocus type="text" v-model="tableData.search" placeholder="Buscar"
                    @keyup.enter="getUsuarios()">
                </div>
                <div class=" pl-1">
                  <select class="block w-full bg-white border border-gray-400 hover:border-gray-500 pr-4 rounded shadow leading-tight focus:outline-none focus:shadow-outline" v-model="tableData.searchColumn">
                    <option value="name">Nombre Completo</option>
                    <option value="username">Nombre de usuario</option>
                    <option value="email">Email2</option>
                  </select>
                </div>
              </div>
            </fieldset>
          </div>

        </div>
        <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
          
            <tbody>
              <tr v-for="(usuario) in usuarios" :key="usuario.id">
                <td style="width: 30%" >{{usuario.name}}</td>
                <td style="width: 20%" >{{usuario.username}}</td>
                <td style="width: 20%" >{{usuario.email}}</td>
                <td style="width: 10%"  class="text-center" v-if="usuario.activo">SI</td>
                <td style="width: 10%" class="text-center bg-info" v-else>NO</td>
                <td v-if="usuario.roles" style="width: 20%" >
                  <ul>
                    <li v-for="(roles, index) in usuario.roles" :key="index" >
                      {{roles.name}}
                    </li>
                  </ul>
                </td>
                <td v-else> - </td>
                <td style="width: 10%" class="gap-2" >
                    <a v-if="$page.props.permisos.includes('Ver-usuarios')" class="bg-blue-500 rounded p-2 text-white mr-2"  :href="'/users/'+usuario.id"><i class="pi pi-eye"></i></a>
               
                    <a v-if="$page.props.permisos.includes('Editar-usuarios')" class="bg-yellow-300 p-2 rounded mr-2" :href="'/users/'+usuario.id+'/edit'"><i class="pi pi-pencil"></i></a>
                  
                    <a v-if="$page.props.permisos.includes('Eliminar-usuarios')" class="cursor-pointer  text-white bg-red-500 p-2 rounded my-1" :id="usuario.id" @click="borrar(usuario.id)"><i class="pi pi-trash"></i></a>
                 
                </td>
              </tr>
            </tbody>
        </datatable>
        <div>
          <pagination :pagination="pagination"
              @prev="getUsuarios(pagination.prevPageUrl)"
              @next="getUsuarios(pagination.nextPageUrl)">
          </pagination>
        </div>
        <ConfirmDialog></ConfirmDialog>
  </app-layout>
</template>

<script>

import AppLayout from '@/Layouts/AppLayout';
import Datatable from '@/Pages/Tabla';
import Pagination from '@/Pages/Pagination';
import ConfirmDialog from 'primevue/confirmdialog';

import ModalExportar from '@/Pages/ModalExportar';
export default {
    components: { 
      datatable: Datatable, pagination: Pagination,AppLayout, ConfirmDialog,ModalExportar
    },
    created() {
      this.getUsuarios();
    },
    data() {
        let sortOrders = {};
        let columns = [
            {label: 'Nombre Completo', name: 'name' }, 
            {label: 'Nombre de usuario', name: 'username'},
            {label: 'Email', name: 'email'},
            {label: 'Activo', name: 'activo'},                
        ];
        const columnasPrincipales = columns.length - 1 ;
          columns.forEach((column) => {
             sortOrders[column.name] = -1;
          });
          columns.push({label: 'Rol', name: 'rol'});
          columns.push({label: 'Acciones', name: 'acciones'});
      
        return {
            usuarios: [],
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
                searchColumn: 'name',
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
     
        getUsuarios(url = '/obtenerusuarios') {
            this.tableData.draw++;
            axios.get(url, {params: this.tableData})
                .then(response => {
                    let data = response.data;
                    this.parametrostabla = data;
                    if (this.tableData.draw == data.draw) {
                        this.usuarios = data.data.data;
                        this.configPagination(data.data);
                    }
                })
                .catch(errors => {
                    this.$toast.add({severity:'error', summary: 'Error', detail:'Al obtener datos', life:5000});
                });
        },
        borrar(info) {
            this.$confirm.require({
                header: 'Confirmacion',
                message: 'Esta seguro que desea eliminar este registro?',
                acceptLabel: 'Si',
                icon: 'pi pi-exclamation-triangle',
                accept: () => {
                  this.$inertia.delete('users/'+info, {
        
                    onSuccess : () => {
                      
                      if(this.$page.props.flash.mensaje){
                        let datos = this.$page.props.flash.mensaje
                        this.$toast.add({severity:datos.type, summary: datos.title, detail:datos.message, life:5000});
                         this.getUsuarios();
                      }
                    },
                  })
                },
                reject: () => {
                    //callback to execute when user rejects the action
                }
            });
        },
        filtro(){
          this.getUsuarios();
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
          this.getUsuarios();
        },
        getIndex(array, key, value) {
            return array.findIndex(i => i[key] == value)
        },

        importardatousuario(usuariosel){
            let par = this.parametrostabla;
          axios.put('/importardatousuario/'+usuariosel.id)
          .then(res => {
            this.getUsuarios('/obtenerusuarios');
            toast.fire({
                icon: 'success',
                title: 'Datos importados correctamente'
            })
          })
          .catch(err => {
              this.$toast.add({severity:'error', summary: 'Error', detail:'Al obtener permisos', life:5000});
            location.reload();
          })
        }
    }
};
</script>
<style>

</style>