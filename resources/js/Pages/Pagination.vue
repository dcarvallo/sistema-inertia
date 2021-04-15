

<template>
    <nav class="pagination flex justify-between mt-3 text-gray-700 text-sm font-light" v-if="!client">
        <span class="page-stats">Página {{pagination.from}} - {{pagination.to}} de {{pagination.total}}</span>
        <div>
        <a v-if="pagination.prevPageUrl" class="select-none text-white bg-blue-600 p-2 rounded cursor-pointer mx-1 pagination-previous" @click="$emit('prev');">
          Atras
        </a>
        <a class="select-none bg-blue-600 p-2 rounded cursor-pointer text-white mx-1 pagination-previous" v-else :disabled="true">
           Atras
        </a>

        <a v-if="pagination.nextPageUrl" class="select-none text-white bg-blue-600 p-2 rounded cursor-pointer pagination-next" @click="$emit('next');">
            Siguiente
        </a>
        <a class="select-none bg-blue-600 p-2 rounded cursor-pointer text-white pagination-next" v-else :disabled="true">
            Siguiente
        </a>
        </div>
    </nav>

    <nav class="pagination text-gray-700 text-sm font-light" v-else>
      <a v-if="pagination.prevPage" class="select-none mx-1 bg-blue-600 p-2 rounded cursor-pointer pagination-previous" @click="$emit('prev');">
            Atras
        </a>
        <a class="select-none bg-blue-600 p-2 rounded cursor-pointer mx-1 pagination-previous" v-else :disabled="true">
           Atras
        </a>
        
        <span class="page-stats">
            {{pagination.from}} - {{pagination.to}} de {{filtered.length}}
            <span v-if="filtered.length < pagination.total">
              (Filtrado de {{pagination.total}} total de entradas)
            </span>
        </span>
        

        <a v-if="pagination.nextPage" class="select-none bg-blue-600 p-2 rounded pagination-next" @click="$emit('next');">
            Siguiente
        </a>
        <a class="select-none bg-blue-600 p-2 rounded pagination-next" v-else :disabled="true">
            Siguiente
        </a>
    </nav>
</template>

<script>
    export default {
        props: ['pagination', 'client', 'filtered'],
        emits: ['next', 'prev']
    }
</script>