<template>
<app-layout>
  <div class="bg-white p-3 rounded altura">
    <div class="text-center my-4">

      <form >
        <div class="mb-4" >
          Introduzca mensaje para todos los usuarios
        </div>
        <div class="flex flex-col items-center">
          <div class="flex justify-center">
            <input class="fappearance-none block bg-grey-lighter text-grey-darker border border-gray-700 rounded py-2 px-4 mr-2" placeholder="texto..." type="text" v-model="mensaje" autocomplete="off">
            <button class="bg-blue-600 text-white p-2 rounded" @click.prevent="enviarmensaje" type="submit">Enviar mensaje</button>
          </div>
          <div v-if="errors.mensaje" class="w-60 bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2">{{ errors.mensaje[0] }}</div>
        </div>
      </form>
    </div>
    <div >
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div >
            <div class="text-center">
              <div class="d-flex justify-content-between">
                <p class="font-bold">Visitantes</p>
                <a>Vista reporte</a>
              </div>
            </div>
              <div class="bg-white rounded shadow">
                <apexchart :width="chart.width" :height="chart.height" :type="chart.type" :options="chart.options" :series="chart.series"></apexchart>
              </div>
          </div>

          <div >
            <div class="border-0">
              <h1 class="text-center font-bold">Productos</h1>
              <div class="text-right">
                <a href="#" class="btn btn-tool btn-sm">
                  <i class="fpi pi-download"></i>
                </a>
                <a href="#" class="btn btn-tool btn-sm">
                  <i class="pi pi-chart-bar"></i>
                </a>
              </div>
            </div>
            <div class="table-responsive p-0">
              <table class="table w-full table-striped table-valign-middle">
                <thead>
                <tr>
                  <th>Producto</th>
                  <th>Precio</th>
                  <th>Venta</th>
                  <th>Mas</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>
                    <img src="img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                    Algun producto
                  </td>
                  <td>$13 USD</td>
                  <td>
                    <small class="text-success mr-1">
                      <i class="pi pi-arrow-up"></i>
                      12%
                    </small>
                    12,000 Sold
                  </td>
                  <td>
                    <a href="#" class="text-muted">
                      <i class="pi pi-search"></i>
                    </a>
                  </td>
                </tr>
                <tr>
                  <td>
                    <img src="img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                    Otro producto
                  </td>
                  <td>$29 USD</td>
                  <td>
                    <small class="text-warning mr-1">
                      <i class="pi pi-arrow-down"></i>
                      0.5%
                    </small>
                    123,234 Sold
                  </td>
                  <td>
                    <a href="#" class="text-muted">
                      <i class="pi pi-search"></i>
                    </a>
                  </td>
                </tr>
                <tr>
                  <td>
                    <img src="img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                    Producto 3
                  </td>
                  <td>$1,230 USD</td>
                  <td>
                    <small class="text-danger mr-1">
                      <i class="pi pi-arrow-down"></i>
                      3%
                    </small>
                    198 Sold
                  </td>
                  <td>
                    <a href="#" class="text-muted">
                      <i class="pi pi-search"></i>
                    </a>
                  </td>
                </tr>
                <tr>
                  <td>
                    <img src="img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                    Item perfecto
                  </td>
                  <td>$199 USD</td>
                  <td>
                    <small class="text-success mr-1">
                      <i class="pi pi-arrow-up"></i>
                      63%
                    </small>
                    87 Sold
                  </td>
                  <td>
                    <a href="#" class="text-muted">
                      <i class="pi pi-search"></i>
                    </a>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
      </div>
      <div class="my-4 border border-gray-300 rounded p-2">
            <div class="border-0">
              <div class="d-flex justify-content-between">
                <h1 class="text-center font-bold">Ventas</h1>
                <a href="javascript:void(0);">Vista reporte</a>
              </div>
            </div>
            <div class="">
              
              <div class="bg-white rounded shadow">
                 <apexchart :width="chart2.width" :height="chart2.height" :type="chart2.type" :options="chart2.options" :series="chart2.series"></apexchart>
              </div>
            </div>
          </div>
    </div>
  </div>
  </app-layout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout'
export default {
  components: {
    AppLayout
  },
    data() {
      return {
        mensaje: '',
        errors: [],
      }
    },
    props: {
      chart: Object,
      chart2: Object,
    },
    methods:{
      enviarmensaje() {
        this.errors = [];
          axios.post('mensajegeneral', { mensaje: this.mensaje })
          .then(response => {
            let datos = response.data;
            this.mensaje = '';
            this.$toast.add({severity:datos.type, summary: datos.title, detail:datos.message, life:5000});
          }).catch(error => {
          if(error.response.status == 422){
            this.errors = error.response.data.errors;
            this.$toast.add({severity:'error', summary: 'Error', detail:'Al enviar mensaje', life:5000});
          }
        });

      },
    }
}
</script>