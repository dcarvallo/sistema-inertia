<template>
<app-layout>
      <form @submit.prevent="editarcargo" @keydown.enter.prevent>
        <div class="form-row">
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="nombre">Nombre*</label>
            <input type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" name="nombre" v-model="form.nombre" placeholder="Nombre Area" autofocus>
            <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="$page.props.errors.nombre" >{{$page.props.errors.nombre}}</label>
          </div>
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="descripcion">Descripción*</label>
            <textarea type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" name="descripcion" v-model="form.descripcion" placeholder="Descripción"></textarea>
            <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="$page.props.errors.descripcion" >{{$page.props.errors.descripcion}}</label>
          </div>
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="nivel">Nivel*</label>
            <input type="number" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2 col-md-6" name="nivel" v-model="form.nivel" placeholder="Nivel"/>
            <span class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="$page.props.errors.nivel" >{{$page.props.errors.nivel}}</span>
          </div>
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="dependiente">Depende de:*</label>
            
            <dropdown 
            v-model="form.dependiente" 
            :options="cargos" 
            :editable="true"
            placeholder="Busqueda"
            optionLabel="nombre"
            optionValue="id"
            class="bg-white border border-gray-700 rounded"
            >
            </dropdown>
            <span class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="$page.props.errors.dependiente" >{{$page.props.errors.dependiente}}</span>
          </div>
          <div class="md:w-1/2">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="tipo">Tipo*</label>
            <select class="form-control col-md-6" v-model="form.tipo">
              <option value="Titular" selected>Titular</option>
              <option value="Eventual">Eventual</option>
              <option value="Externo">Externo</option>
            </select>
            <span class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="$page.props.errors.tipo" >{{$page.props.errors.tipo}}</span>
          </div>
          <div class="md:w-1/2">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="ubicacion_id">Area*</label>
           

            <dropdown 
            v-model="form.area_id" 
            :options="areas" 
            :editable="true"
            placeholder="Busqueda"
            optionLabel="nombre"
            optionValue="id"
            class="bg-white border border-gray-700 rounded"
            >
            </dropdown>
            
            <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="$page.props.errors.area" >{{$page.props.errors.area}}</label>
          </div>
          <button type="submit" class="select-none mt-5 bg-blue-600 text-white rounded p-2 hover:bg-blue-800" >Guardar</button>
        </div>
      </form>
    </app-layout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout'
import Dropdown from 'primevue/dropdown';
export default {
props: ['cargo', 'areas', 'cargos'],
 components: { Dropdown, AppLayout },
data() {
  return {
    form: this.cargo,
  }
},
methods: {
  editarcargo()
    {
      this.$inertia.put('/cargos/'+this.form.id, this.form, {
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