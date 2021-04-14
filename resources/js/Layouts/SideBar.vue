<template>
  <div x-bind:class="sidebarOpen ? 'block' : 'hidden'" x-on:click="sidebarOpen = false" class="fixed z-20 inset-0 bg-gray-800 opacity-50 transition-opacity lg:hidden"></div>

    <div x-bind:class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-gray-800 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0">
    
      <div class="flex items-center justify-center my-4">
        <div class=" ">
            <a v-if="$page.props.nombreempresa.nombre != null" :href="route('dashboard')" class="flex justify-center items-center">
              <img v-if="$page.props.imagenempresa.imagen_empresa != null" :src="'/storage/'+$page.props.imagenempresa.imagen_empresa" alt="" class="w-10" style="opacity: .8">
              
              <span class="text-white text-xl mx-2 font-semibold"> {{$page.props.nombreempresa.nombre }}</span>
            </a>
        </div>
      </div>
        <nav class="mt-4 text-sm">
      
        <div v-if="$page.props.permisos.includes('Navegar-admin') || 
              $page.props.permisos.includes('Navegar-usuarios') ||
              $page.props.permisos.includes('Navegar-roles') ||
              $page.props.permisos.includes('Navegar-permisos') ||
              $page.props.permisos.includes('Administrador-archivos') " 
              class="" x-data="{open:false}">

          <div x-on:click="open = true" class="cursor-pointer flex justify-between items-center py-2 px-6 text-gray-400 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100">
            <div>
              <i class="pi pi-briefcase"></i>
              <span class="mx-3">Gestión</span>
            </div>
            <i class=" pi pi-chevron-circle-left"></i>
          </div>

          <div class="flex flex-col mt-2 bg-gray-700" x-show="open" x-on:click.away="open=false" x-transition:enter-start="transition ease-in duration-3000">
          
            <a v-if="$page.props.permisos.includes('Navegar-usuarios')" :href="route('users.index')" class="cursor-pointer flex items-center  py-2 px-6 text-gray-400 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100">
              <i class="pi pi-circle-off"></i>
              <span class="mx-3">Usuarios</span>
            </a>
            <a v-if="$page.props.permisos.includes('Navegar-roles')" :href="route('roles.index')" class="cursor-pointer flex items-center  py-2 px-6 text-gray-400 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100">
              <i class="pi pi-circle-off"></i>
              <span class="mx-3">Roles</span>
            </a>
            <a v-if="$page.props.permisos.includes('Navegar-permisos')" :href="route('permisos.index')" class="cursor-pointer flex items-center  py-2 px-6 text-gray-400 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100">
              <i class="pi pi-circle-off"></i>
              <span class="mx-3">Permisos</span>
            </a>
            <a v-if="$page.props.permisos.includes('Navegar-admin')" :href="route('admin.index')" class="cursor-pointer flex items-center  py-2 px-6 text-gray-400 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100">
              <i class="pi pi-circle-off"></i>
              <span class="mx-3">Admin</span>
            </a>
          </div>
        </div>
        <div v-if="$page.props.permisos.includes('Navegar-empresas') || 
              $page.props.permisos.includes('Navegar-ubicaciones') ||
              $page.props.permisos.includes('Navegar-departamentos') ||
              $page.props.permisos.includes('Navegar-areas') ||
              $page.props.permisos.includes('Navegar-cargos')" 
              class="" x-data="{open:false}">
          
          <div x-on:click="open = true" class="cursor-pointer flex justify-between items-center py-2 px-6 text-gray-400 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100">
            <div>
              <i class="pi pi-th-large"></i>
              <span class="mx-3">Estructura empresarial</span>
            </div>
              <i class="right pi pi-chevron-circle-left"></i>
          </div>
          <div class="flex flex-col mt-2 bg-gray-700" x-show="open" x-on:click.away="open=false" x-transition:enter-start="transition ease-in duration-3000" > 
            
            <a v-if="$page.props.permisos.includes('Navegar-empresas')" :href="route('empresas.index')" class="cursor-pointer flex items-center  py-2 px-6 text-gray-400 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100">
              <i class="pi pi-circle-off"></i>
              <span class="mx-3">Empresa</span>
            </a>
            <a v-if="$page.props.permisos.includes('Navegar-ubicaciones')" :href="route('ubicaciones.index')" class="cursor-pointer flex items-center  py-2 px-6 text-gray-400 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100">
              <i class="pi pi-circle-off"></i>
              <span class="mx-3">Ubicaciones</span>
            </a>
            <a v-if="$page.props.permisos.includes('Navegar-departamentos')" :href="route('departamentos.index')" class="cursor-pointer flex items-center  py-2 px-6 text-gray-400 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100">
              <i class="pi pi-circle-off"></i>
              <span class="mx-3">Departamentos</span>
            </a>
            <a v-if="$page.props.permisos.includes('Navegar-areas')" :href="route('areas.index')" class="cursor-pointer flex items-center  py-2 px-6 text-gray-400 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100">
              <i class="pi pi-circle-off"></i>
              <span class="mx-3">Áreas</span>
            </a>
            <a v-if="$page.props.permisos.includes('Navegar-cargos')" :href="route('cargos.index')" class="cursor-pointer flex items-center  py-2 px-6 text-gray-400 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100">
              <i class="pi pi-circle-off"></i>
              <span class="mx-3">Cargos</span>
            </a>
          </div>
        </div>
      </nav>
      
  </div>
</template>
<script>

export default {
  props:['isOpen'],
  data() {
    return {
      activeClass: false,
      inactiveClass: false,
    }
  },
  
}
</script>