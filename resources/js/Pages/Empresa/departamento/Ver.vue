<template>
  <app-layout>
      <div>
        <p class="mb-0">{{departamento.nombre}}</p>
        <hr class="border-gray-900">
        <label class="block tracking-wide text-grey-darker font-bold mb-2"><strong>Nombre</strong> </label>
      </div>
      <br>
      <div>
        <p class="mb-0">{{departamento.descripcion}}</p>
        <hr class="border-gray-900">
        <label class="block tracking-wide text-grey-darker font-bold mb-2">Descripción</label>
      </div>
      <br>
      <div>
        <p class="mb-0">{{departamento.encargado}}</p>
        <hr class="border-gray-900">
        <label class="block tracking-wide text-grey-darker font-bold mb-2">Encargado del departamento</label>
      </div>
      <br>
      <div>
        <p class="mb-0">{{departamento.ubicacion.nombre}}</p>
        <hr class="border-gray-900">
        <label class="block tracking-wide text-grey-darker font-bold mb-2">Ubicacion</label>
      </div>
  </app-layout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout'
export default {
  props:['departamento'],
  components:{AppLayout},
}
</script>