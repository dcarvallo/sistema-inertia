<template>
  <app-layout>
      <form @submit.prevent="crearubicacion" @keydown.enter.prevent>
        <div class="form-row">
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="nombre">Nombre*</label>
            <input type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="form.nombre" placeholder="Ejem. Edificio 2" autofocus>
            <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="$page.props.errors.nombre" >{{$page.props.errors.nombre}}</label>
          </div>
          
          <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="descripcion">Descripción*</label>
            <textarea type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="form.descripcion" placeholder="Descripción de ubicacion"></textarea>
            <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="$page.props.errors.descripcion" >{{$page.props.errors.descripcion}}</label>
          </div>
           <div class="form-group">
            <label class="block tracking-wide text-grey-darker font-bold mb-2" for="locacion">Locación*</label>
            <textarea type="text" class="fappearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-2 px-4 mb-2" v-model="form.locacion" placeholder="Calle de la ubicacion"></textarea>
            <label class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2" v-if="$page.props.errors.locacion" >{{$page.props.errors.locacion}}</label>
          </div>
          <button type="submit" class="select-none mt-5 bg-blue-600 text-white rounded p-2 hover:bg-blue-800" >Guardar</button>
        </div>
      </form>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
export default {
 components: { AppLayout },
data() {
  return {
    form: this.$inertia.form({
      nombre: '',
      descripcion: '',
      locacion: '',
    })
  }
},
methods: {
  crearubicacion()
    {
      this.$inertia.post(this.route('ubicaciones.store'), this.form, {
        onSuccess : () => {
          this.form.reset()
          if(this.$page.props.flash.mensaje){
            let datos = this.$page.props.flash.mensaje
            this.$toast.add({severity:datos.type, summary: datos.title, detail:datos.message, life:5000});
          }
        },
      });
    }
},
}
</script>