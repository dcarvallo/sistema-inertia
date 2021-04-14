<template>
  <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200 font-roboto">
    <Toast />
    <SideBar />

    <div class="flex-1 flex flex-col overflow-hidden">
      <Header :titulo="titulo" :breadcrumb="breadcrumb" />
 
      <main class="flex-1 rounded overflow-x-hidden overflow-y-auto bg-gray-100">
        <div class="px-5 min-h-full pb-12 pt-3 ">
          
          <slot />
        </div>
      </main>
    </div>
    </div>
</template>

<script>
    import Header from '@/Layouts/Header'
    import SideBar from '@/Layouts/SideBar'
    import Toast from 'primevue/toast';
    export default {
      props:['titulo', 'breadcrumb'],
      components: {
          Header,
          SideBar,
          Toast
      },
    }

    // Echo.channel('notificacion').listen('NuevaNotificacion', (e) => {
    //   this.$toast.add({severity:'warning', summary: 'Notificacion', detail:e.message});
    // });
    
</script>
<style>
/* toast */
.p-toast .p-toast-message .p-toast-message-content{
  padding: 7px
}
</style>