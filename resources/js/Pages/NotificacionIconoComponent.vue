<template>

    <div class="mr-2">
        <button v-on:click="abrir = ! abrir" class="flex rounded text-gray-600 focus:outline-none">
         
          <i class="pi pi-bell p-text-secondary" style="font-size: 1.5rem"></i>
          <span v-if="cantidadnotificaciones" class="badge badge-light text-xs bg-yellow-200 px-1 rounded border border-gray-600">
            {{cantidadnotificaciones}}
          </span> 
      </button>

      <div v-show="abrir" v-on:click="abrir = false" class="fixed inset-0 h-full w-full z-10"></div>

      <div v-show="abrir" class="absolute right-0 mt-2 w-80 bg-white border border-gray-400 rounded-lg shadow-xl overflow-hidden z-10" style="width:20rem;">
          <div v-if="cantidadnotificaciones">
            <a v-for="(notificacion) in notifica" :key="notificacion.id"  href="#" class="flex items-center px-4 py-3 text-gray-600 hover:text-white hover:bg-gray-800 -mx-2">
                <img class="h-8 w-8 rounded-full object-cover mx-1" src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=634&q=80" alt="avatar">
                <p class="text-sm mx-2">
                   {{notificacion.data.mensaje}}
                </p> 
                
            </a>
          </div>
          <div v-else>
            <p class="flex items-center px-4 py-3 text-gray-600 -mx-2">No tiene notificaciones </p>
          </div>
      </div>
    </div>
</template>
<script>

export default {
  
  created(){
    this.notimetodo();
  },
  mounted(){
      Echo.private('App.Models.User.' + this.$page.props.user.id)
      .notification((NotificacionGeneral) => {
        this.notimetodo();
        this.$toast.add({severity:'warn', summary:'Notificacion', detail:'Tiene una nueva notificación'});
      });
  },
  data() {
    return {
      abrir: false,
      cantidadnotificaciones: 0,
      notifica: ''
    }
  },

  methods:{
    
    notimetodo(){
      //falta permisos revisar
      axios.get('/notimetodo', {usuarioid: this.$page.props.user.id})
      .then(res => {
        this.cantidadnotificaciones= res.data.length, 
        this.notifica= res.data
      })
      .catch(err => {
        console.error(err); 
      })
    }
  }
}

</script>
<style >
  .badge { 
    position: relative; 
    bottom: -20px; 
    right: 10px;
  }
</style>