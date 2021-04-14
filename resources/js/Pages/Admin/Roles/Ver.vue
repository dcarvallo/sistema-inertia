<template >
  <section class="bg-white p-3 rounded">
      <div>
        <p class="mb-0">{{role.name}}</p>
        <hr class="border-gray-900">
        <label class="block tracking-wide text-grey-darker font-bold mb-2">Nombre </label>
      </div>
      <br>
      <div>
        <p class="mb-0">{{role.description}}</p>
        <hr class="border-gray-900">
        <label class="block tracking-wide text-grey-darker font-bold mb-2" for="nombre">Descripción</label>
      </div>
      <br>
      <div>
        <p class="mb-0">{{role.category}}</p>
        <hr class="border-gray-900">
        <label class="block tracking-wide text-grey-darker font-bold mb-2" for="nombre">Categoria</label>
      </div>
      <hr>
      <div class="mt-5">
        <label class="text-center block tracking-wide text-grey-darker font-bold mb-2" for="nombre">Permisos</label>
        <hr class="border-gray-900">
        <ul>
            <li v-for="(permiso, index) in permisos" :key="index"><strong>{{permiso.name}}</strong>    - {{permiso.description}}</li>
        </ul>
      </div>
  </section>
</template>
<script>
export default {
  props:['role', 'permisos'],
}
</script>