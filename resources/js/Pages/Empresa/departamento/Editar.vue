<template>
<app-layout>
      <form @submit.prevent="editardepartamento" @keydown.enter.prevent>
        <div>
          <div>
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="nombre">Nombre*</label>
            <input type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" name="nombre" v-model="form.nombre" placeholder="Nombre departamento" required autofocus>
            <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="$page.props.errors.nombre" >{{$page.props.errors.nombre[0]}}</label>
          </div>
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="descripcion">Descripción*</label>
            <textarea type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" name="descripcion" v-model="form.descripcion" placeholder="Descripción"></textarea>
            <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="$page.props.errors.descripcion" >{{$page.props.errors.descripcion[0]}}</label>
          </div>
          <div class="md:w-1/2">
            <label class="block tracking-wide text-grey-darker font-bold mb-2">Encargado del departamento</label>
           
            <dropdown 
            v-model="form.encargado" 
            :options="cargos" 
            :editable="true"
            placeholder="Busqueda"
            optionLabel="nombre"
            optionValue="nombre"
            class="bg-white border border-gray-700 rounded"
            >
            </dropdown>
          </div>
          <div class="md:w-1/2">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="ubicacion_id">Ubicacion*</label>
            
            <dropdown 
            v-model="form.ubicacion_id"
            :options="ubicaciones"
            :editable="true"
            placeholder="Busqueda"
            optionLabel="nombre"
            optionValue="id"
            class="bg-white border border-gray-700 rounded"
            >
            </dropdown>
            <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="$page.props.errors.ubicacion" >{{$page.props.errors.ubicacion[0]}}</label>
          </div>
          <button type="submit" class=" select-none mt-5 bg-blue-600 text-white rounded p-2 hover:bg-blue-800" >Guardar</button>
        </div>
      </form>
    </app-layout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout'
import Dropdown from 'primevue/dropdown';
export default {
props: ['ubicaciones', 'cargos', 'departamento'],
 components: { Dropdown, AppLayout },
data() {
  return {
    form: this.departamento,
  }
},
methods: {
  editardepartamento()
    {
      this.$inertia.put('/departamentos/'+this.form.id, this.form, {
        onSuccess : () => {
          if(this.$page.props.flash.mensaje){
            let datos = this.$page.props.flash.mensaje
            this.$toast.add({severity:datos.type, summary: datos.title, detail:datos.message, life:5000});
          }
        },
      })
    }
},
}
</script>