<template>
  <div>
   <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper" @click="$emit('close')">
        <div class="modal-container" @click.stop>
          <div class="h-auto p-4 mx-2 text-left bg-white rounded  md:max-w-xl md:p-6 lg:p-8 md:mx-0" >
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
              Exportar lista
            </h3>

            <div class="mt-2">
              
              <form method="post" :action="url" >
                <input type="hidden" name="_token" :value="$page.props.csrf_token">
                    <div class="flex content-around my-5 mb-10"> 
                      <select class="block w-full bg-white border border-gray-400 hover:border-gray-500 px-1 rounded shadow leading-tight focus:outline-none focus:shadow-outline" name="exportar"  v-model="form.exportar">
                        <option value="excel" selected>Excel </option>
                        <option value="pdf">PDF</option>
                      </select>
                    </div>
                    <div class="form-group d-flex flex-column"> 
                        <input type="hidden" name="busquedacolumna" checked v-model="form.busquedacolumna" >  
                        <input type="hidden" name="datobusqueda" checked v-model="form.datobusqueda" >  
                        <input type="hidden" name="_token" :value="csrf">
                    </div>
                <div class="modal-footer">
                  <div @click="$emit('close')" class="select-none cursor-pointer inline-flex justify-center px-4 py-2 border bg-white rounded hover:bg-gray-100">
                    Cerrar
                  </div>
                  <button type="submit" class="select-none px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700">Exportar</button>
                </div>
              </form>
          </div>
        </div>
        </div>
        </div>
      </div>
    </div>
  </transition>
  </div>
</template>
<script>
export default {
  props: ['url','tableData'],
  emits:['close'],
  data() {
    return {
      exportar: 'excel',
       csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
       form: this.$inertia.form({
            exportar: 'excel',
            busquedacolumna: this.tableData.searchColumn,
            datobusqueda: this.tableData.search
        })
    }
  },
  methods: {
    funcionexportar(){
      let datos = new FormData();
      datos.append('exportar', this.form.exportar);
      datos.append('busquedacolumna', this.form.busquedacolumna);
      datos.append('datobusqueda', this.form.datobusqueda);

      // this.form.post(this.route(this.url), datos)
      window.open(`exportar-roles?slug=${datos}`, '_blank') 
    },
  }
}
</script>
<style>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 300px;
  margin: 0px auto;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>