
<template>
  <div>
    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class=" overflow-hidden  sm:rounded-lg">
            <table class="min-w-full divide-y bg-white rounded divide-gray-200 table container striped my-2">
              <thead class="bg-gray-800 text-white">
                <tr style="cursor: pointer" class="text-center">
                  <th class="px-4 py-1 border border-gray-100" v-for="column in columns" :key="column.name" @click="$emit('sort', column.name)">
                    {{ column.label }}

                    <label class=" mb-0" v-if="sortKey === column.name && sortOrders[column.name]">
                      <i v-if="sortOrders[column.name] == 1"  style="cursor: pointer" class="pi pi-sort-amount-down"></i>
                      <i v-if="sortOrders[column.name] == -1" style="cursor: pointer" class="pi pi-sort-amount-up"></i>
                    </label>
                  </th>
                </tr>
              </thead>
              <slot> </slot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["columns", "sortKey", "sortOrders"],
  emits: ['sort']
};
</script>
<style>
  /* table.table-bordered > tbody > tr > td {
    border: 1px solid rgb(153, 153, 153);
  }
  table.table-bordered > thead > tr > th {
    border: 1px solid rgb(177, 177, 177);
  } */
</style>