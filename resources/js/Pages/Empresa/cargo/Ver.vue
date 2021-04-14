<template>
  <app-layout>
    <div  class="bg-white p-3 rounded altura">
      <div>
        <p class="mb-0">{{cargo.nombre}}</p>
        <hr class="border-gray-900">
        <label class="block tracking-wide text-grey-darker font-bold mb-2"><strong>Nombre</strong> </label>
      </div>
      <br>
      <div>
        <p class="mb-0">{{cargo.descripcion}}</p>
        <hr class="border-gray-900">
        <label class="block tracking-wide text-grey-darker font-bold mb-2">Descripción</label>
      </div>
      <br>
      <div>
        <p class="mb-0">{{cargo.nivel}}</p>
        <hr class="border-gray-900">
        <label class="block tracking-wide text-grey-darker font-bold mb-2">Nivel</label>
      </div>
      <br>
      <div>
        <p class="mb-0">{{cargo.tipo}}</p>
        <hr class="border-gray-900">
        <label class="block tracking-wide text-grey-darker font-bold mb-2">Tipo</label>
      </div>
      <br>
      <div>
        <p class="mb-0">{{dependiente.nombre}}</p>
        <hr class="border-gray-900">
        <label class="block tracking-wide text-grey-darker font-bold mb-2">Depende de</label>
      </div>
      <br>
      <div>
        <p class="mb-0">{{cargo.area.nombre}}</p>
        <hr class="border-gray-900">
        <label class="block tracking-wide text-grey-darker font-bold mb-2">Área</label>
      </div>
    </div>
  </app-layout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout'
export default {
  props:['cargo', 'dependiente'],
  components:{AppLayout},
  created(){
    console.log(this.cargo)
  }
}
</script>