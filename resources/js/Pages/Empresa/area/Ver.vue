<template>
  <app-layout>
    <div  class="bg-white p-3 rounded altura">
      <div>
        <p class="mb-0">{{area.nombre}}</p>
        <hr class="border-gray-900">
        <label class="block tracking-wide text-grey-darker font-bold mb-2"><strong>Nombre</strong> </label>
      </div>
      <br>
      <div>
        <p class="mb-0">{{area.descripcion}}</p>
        <hr class="border-gray-900">
        <label class="block tracking-wide text-grey-darker font-bold mb-2">Descripción</label>
      </div>
      <br>
      <div>
        <p class="mb-0">{{area.encargado}}</p>
        <hr class="border-gray-900">
        <label class="block tracking-wide text-grey-darker font-bold mb-2">Encargado del Área</label>
      </div>
      <br>
      <div>
        <p class="mb-0">{{area.departamento.nombre}}</p>
        <hr class="border-gray-900">
        <label class="block tracking-wide text-grey-darker font-bold mb-2">Departamento</label>
      </div>
    </div>
  </app-layout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout'
export default {
  props:['area'],
  components:{AppLayout},
}
</script>