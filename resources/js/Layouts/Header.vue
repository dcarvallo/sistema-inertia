<template>
<header class="flex justify-between items-center py-4 px-6 bg-white border-b-4 border-gray-400">
    <div class="flex items-center w-1/5">
      <button
        x-on:click="sidebarOpen = true" class="text-gray-500 5 focus:outline-none lg:hidden mr-2">
        <svg
          class="h-6 w-6"
          viewBox="0 0 24 24"
          fill="none"
          xmlns="http://www.w3.org/2000/svg">
          <path
            d="M4 6H20M4 12H20M4 18H11"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"/>
        </svg>
      </button>

      <div class="hidden ml-1 sm:flex sm:items-center">
        <a :href="route('dashboard')"><i class="pi pi-home"></i></a>
        <ul v-for="(item, index) in breadcrumb" :key="index">
          <div class="flex items-center">
            <i class="mx-1 pi pi-angle-right"></i>
            <a :href="item.enlace">{{item.nombre}}</a>
          </div>
        </ul>
      </div>

    </div>

    <div class="w-3/5 text-center">
       <h2 class="text-sm font-bold sm:text-lg" >{{titulo ? titulo : 'Inicio'}}</h2>
    </div>

    <div class="flex justify-end items-center w-1/5">
     
      <Icononorificacion />
        
      <div x-data="{ dropdownOpen: false }"  class="relative">
        <button
          x-on:click="dropdownOpen = ! dropdownOpen" class="relative block h-8 w-8 rounded-full overflow-hidden shadow focus:outline-none">
          <img
            class="h-full w-full object-cover"
            :src="'/storage/'+$page.props.user.fotografia"/>
        </button>

        <div x-show="dropdownOpen" x-on:click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

        <div x-show="dropdownOpen" class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10">
          <p class="block text-center px-4 font-bold py-2 border-b text-sm text-gray-700">{{$page.props.user.username}}</p>
          <a :href="route('perfil')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-800 hover:text-white">Perfil</a>
          <a :href="route('recordatorio.index')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-800 hover:text-white">Calendario</a>
          
          <a href="#" @click="logout" class="w-full text-left cursor-pointer block px-4 py-2 text-sm text-gray-700 hover:bg-gray-800 hover:text-white" >Salir</a>
          
        </div>
      </div>
    </div>
  </header>
  
</template>
<script>
import Icononorificacion from '@/Pages/NotificacionIconoComponent'
  export default {
    props: ['titulo', 'breadcrumb'],
    components: {Icononorificacion},
    methods:{
      logout() {
            axios.post(route("logout")).then(response => {
                window.location = "/";
            });
        }
    }
  };
</script>