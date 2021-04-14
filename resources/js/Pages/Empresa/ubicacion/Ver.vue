<template>
  <app-layout>
    <div  class="bg-white p-3 rounded altura">
      <div>
        <p class="mb-0">{{ubicacion.nombre}}</p>
        <hr class="border-gray-900">
        <label class="block tracking-wide text-grey-darker font-bold mb-2"><strong>Nombre</strong> </label>
      </div>
      <br>
      <div>
        <p class="mb-0">{{ubicacion.descripcion}}</p>
        <hr class="border-gray-900">
        <label class="block tracking-wide text-grey-darker font-bold mb-2">Descripción</label>
      </div>
      <br>
      <div>
        <p class="mb-0">{{ubicacion.locacion}}</p>
        <hr class="border-gray-900">
        <label class="block tracking-wide text-grey-darker font-bold mb-2">Locación</label>
      </div>
    </div>
  </app-layout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout'
export default {
  props:['ubicacion'],
  components:{AppLayout},
}
</script>