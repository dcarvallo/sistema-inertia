<template>
<app-layout>
    <div class="container-fluid">
      <div class="flex flex-col justify-between sm:flex-row">
        <div class="flex items-end my-1">
          <div class="mr-2">
                <select class="block w-full bg-white border border-gray-400 hover:border-gray-500 rounded shadow leading-tight focus:outline-none focus:shadow-outline"  v-model="tableData.length" @change="getUbicaciones()" >
              <option v-for="(records, index) in perPage"  :key="index" :value="records">
                {{ records }}
              </option>
            </select>
          </div>
          <div v-if="$page.props.permisos.includes('Crear-ubicaciones')" class="w-auto mr-1">
            <a class="flex items-center p-2 text-white bg-green-500 rounded select-none no-outline focus:shadow-outline" href="/ubicaciones/create">
              <i class="pi pi-plus-circle"></i>
              <span class="hidden md:block pl-2">Crear</span>
            </a>
          </div>
          <div v-if="$page.props.permisos.includes('Exportar-ubicaciones')" class="w-auto">
            <!-- modal div -->
               <div class=" cursor-pointer flex items-center p-2 text-white bg-blue-500 rounded select-none no-outline focus:shadow-outline" @click="showModal = true">
                  <i class="pi pi-download"></i> 
                  <span class="hidden md:block pl-2"> Exportar </span>
                </div>
                <ModalExportar url="/exportar-ubicaciones" v-if="showModal" @close="showModal = false" :tableData="tableData"/>
                    
          </div>
        </div>
        <div>

          <fieldset class="border p-1">
            <legend class="w-auto my-0">
              <span class="my-0 text-sm"> Buscar por</span>
          </legend>
          <div class="flex items-center">
            <div class="col pr-1">
              <input class="bg-white h-8 px-3 pr-10 rounded-md text-sm focus:outline-none w-32 md:w-64 "  type="text"   v-model="tableData.search"  placeholder="Buscar" @keyup.enter="getUbicaciones()"/>
            </div>
            <div class="col pl-1">
              <select class="block w-full bg-white border border-gray-400 hover:border-gray-500 px-2 pr-4 rounded shadow leading-tight focus:outline-none focus:shadow-outline" v-model="tableData.searchColumn">
                <option value="nombre">Nombre</option>
                <option value="description">Descripción</option>
                <option value="locacion">Locación</option>
              </select>
            </div>
          </div>
        </fieldset>
              </div>
      </div>
    </div>
    <datatable :columns="columns"  :sortKey="sortKey"  :sortOrders="sortOrders"  @sort="sortBy">
      <tbody>
        <tr v-for="ubicacion in ubicaciones" :key="ubicacion.id">
          <td style="width: 20%">{{ ubicacion.nombre }}</td>
          <td style="width: 30%" class="text-justify">
            {{ ubicacion.descripcion }}
          </td>
          <td style="width: 30%">{{ ubicacion.locacion }}</td>
          <td style="width: 20%">{{ ubicacion.empresa.nombre }}</td>
          <td  class="text-center">
            <!-- <div class="flex justify-center"> -->
              <a v-if="$page.props.permisos.includes('Ver-ubicaciones')" class="bg-blue-500 mr-2 rounded p-2 text-white" :href="'/ubicaciones/' + ubicacion.id" ><i class="pi pi-eye"></i></a>
            <!-- </div>
          </td>
          <td v-if="$page.props.permisos.includes('Editar-ubicaciones')" class="text-center"> -->
            <!-- <div class="flex justify-center"> -->
              <a v-if="$page.props.permisos.includes('Editar-ubicaciones')" class="bg-yellow-300 mr-2 p-2 rounded" :href="`/ubicaciones/${ubicacion.id}/edit`" ><i class="pi pi-pencil"></i></a>
            <!-- </div>
          </td>
          <td v-if="$page.props.permisos.includes('Eliminar-ubicaciones')" class="text-center"> -->
            <!-- <div class="flex justify-center"> -->
              <a v-if="$page.props.permisos.includes('Eliminar-ubicaciones')" class="cursor-pointer  text-white bg-red-500 p-2 rounded my-1" @click="borrar(ubicacion.id)"><i class="pi pi-trash"></i ></a>
            <!-- </div> -->
          </td>
        </tr>
      </tbody>
    </datatable>

    <!-- <ModalEliminar :url="url" v-if="modaleliminar" @eliminado="metodo" @close="modaleliminar = false" /> -->

    <div class="d-flex justify-content-end">
      <pagination
        :pagination="pagination"
        @prev="getUbicaciones(pagination.prevPageUrl)"
        @next="getUbicaciones(pagination.nextPageUrl)"
      >
      </pagination>
    </div>
    <ConfirmDialog></ConfirmDialog>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Datatable from '@/Pages/Tabla';
import Pagination from '@/Pages/Pagination';
import ModalExportar from '@/Pages/ModalExportar';
import ConfirmDialog from 'primevue/confirmdialog';
export default {
  components: { datatable: Datatable, pagination: Pagination, ModalExportar, ConfirmDialog, AppLayout },
  created() {
    this.getUbicaciones();   
  },
  data() {
    let sortOrders = {};
    let columns = [
      { label: "Nombre", name: "nombre" },
      { label: "Descripcion", name: "descripcion" },
      { label: "Locacion", name: "locacion" },
      { label: "Empresa", name: "empresa" },
      { label: "Acciones", name: "acciones" },
    ];
    var columnasPrincipales = columns.length - 1;
    columns.forEach((column) => {
      sortOrders[column.name] = -1;
    });
    return {
      exportar: "excel",
      ubicaciones: [],
      showModal: false,
      columns: columns,
      columnasPrincipales: columnasPrincipales,
      sortKey: "",
      sortOrders: sortOrders,
      perPage: ["15", "30", "50"],
      tableData: {
        draw: 0,
        length: 15,
        search: "",
        column: 0,
        dir: "asc",
        searchColumn: "nombre",
      },
      pagination: {
        lastPage: "",
        currentPage: "",
        total: "",
        lastPageUrl: "",
        nextPageUrl: "",
        prevPageUrl: "",
        from: "",
        to: "",
      },
    };
  },
  methods: {
    
    getUbicaciones(url = "/obtenerubicaciones") {
      this.tableData.draw++;
      axios
        .get(url, { params: this.tableData })
        .then((response) => {
          let data = response.data;
          this.parametrostabla = data;
          if (this.tableData.draw == data.draw) {
            this.ubicaciones = data.data.data;
            this.configPagination(data.data);
          }
        })
        .catch((errors) => {
          this.$toast.add({severity:'error', summary: 'Error', detail:'Al obtener ubicaciones', life:5000});
        });
    },
    borrar(info) {
            this.$confirm.require({
                header: 'Confirmacion',
                message: 'Esta seguro que desea eliminar este registro?',
                acceptLabel: 'Si',
                icon: 'pi pi-exclamation-triangle',
                accept: () => {
                  this.$inertia.delete('ubicaciones/'+info, {
        
                    onSuccess : () => {
                      
                      if(this.$page.props.flash.mensaje){
                        let datos = this.$page.props.flash.mensaje
                        this.$toast.add({severity:datos.type, summary: datos.title, detail:datos.message, life:5000});
                         this.getUbicaciones();
                      }
                    },
                  })
                },
                reject: () => {
                    //callback to execute when user rejects the action
                }
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
      this.tableData.column = this.getIndex(this.columns, "name", key);
      this.tableData.dir = this.sortOrders[key] === 1 ? "asc" : "desc";
      if (this.tableData.column <= this.columnasPrincipales)
        this.getUbicaciones();
    },
    getIndex(array, key, value) {
      return array.findIndex((i) => i[key] == value);
    },
  },
};
</script>