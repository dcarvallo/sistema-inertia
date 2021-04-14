<template>
  <div>
   <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper" @click="$emit('close')">
        <div class="modal-container" @click.stop>
          <div class="h-auto p-4 mx-2 text-left bg-white rounded  md:max-w-xl md:p-6 lg:p-8 md:mx-0" >
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
              Eliminar registro
            </h3>

            <div class="mt-2">
              
              <form @submit.prevent="eliminar()" >
                <input type="hidden" name="_token" :value="$page.props.csrf_token">
                    <div class="flex content-around my-5 mb-10"> 
                      <p>Esta seguro que desea eliminar este registro?</p>
                    </div>
                <div class="text-right">
                  <div @click="$emit('close')" class="mx-2 select-none cursor-pointer inline-flex justify-center px-4 py-2 border bg-white rounded hover:bg-gray-100">
                    Cerrar
                  </div>
                  <button type="submit" class="select-none px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700">Eliminar</button>
                </div>
              </form>
          </div>
        </div>
        </div>
        </div>
      </div>
    </div>
  </transition>
  </div>
</template>
<script>
export default {
  props: ['url'],
  emits:['close', 'eliminado'],
  data() {
    return {
    }
  },
  methods: {
    eliminar(){
      
      this.$inertia.delete(this.url, {
        
        onSuccess : () => {
          
          if(this.$page.props.flash.mensaje){
            let datos = this.$page.props.flash.mensaje
            this.$toast.add({severity:datos.type, summary: datos.title, detail:datos.message, life:5000});
          this.$emit('eliminado', true);
          }
        },
      })
    },
  }
}
</script>
<style>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  min-width: 350px;
  margin: 0px auto;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>